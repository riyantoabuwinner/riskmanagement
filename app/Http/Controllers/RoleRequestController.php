<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\Unit;
use App\Models\User;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Notifications\RoleRequestSubmitted;

class RoleRequestController extends Controller
{
    use HasAuditLog;
    // ── Roles yang bisa diajukan ──
    const AVAILABLE_ROLES = [
        'Risk Manager' => 'Risk Manager — Bertanggung jawab atas keseluruhan program manajemen risiko',
        'Risk Officer' => 'Risk Officer — Memantau dan melaporkan risiko di unit kerja',
        'Risk Owner' => 'Risk Owner — Pemilik risiko di level operasional',
    ];

    /**
     * Tampilkan form pengajuan role (untuk user tanpa role).
     */
    public function create()
    {
        $user = Auth::user();

        // Jika sudah punya role, redirect ke dashboard
        if ($user->roles->isNotEmpty()) {
            return redirect()->route('dashboard');
        }

        // Cek pengajuan yang ada
        $existingRequest = RoleRequest::where('user_id', $user->id)->latest()->first();

        if ($existingRequest) {
            if ($existingRequest->isPending()) {
                return view('role-request.pending', compact('existingRequest'));
            }
            if ($existingRequest->isRejected()) {
                // Tampilkan form lagi dengan info penolakan
                $units = Unit::orderBy('nama_unit')->get();
                $availableRoles = self::AVAILABLE_ROLES;
                return view('role-request.create', compact('units', 'availableRoles', 'existingRequest'));
            }
        }

        $units = Unit::orderBy('nama_unit')->get();
        $availableRoles = self::AVAILABLE_ROLES;
        $existingRequest = null;

        return view('role-request.create', compact('units', 'availableRoles', 'existingRequest'));
    }

    /**
     * Simpan pengajuan role baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Jika sudah punya role, redirect
        if ($user->roles->isNotEmpty()) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'requested_role' => ['required', 'in:Risk Manager,Risk Officer,Risk Owner'],
            'position' => ['required', 'string', 'max:255'],
            'unit_id' => ['required', 'exists:units,id'],
            'sk_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ], [
            'requested_role.required' => 'Pilih role yang ingin diajukan.',
            'requested_role.in' => 'Role yang dipilih tidak valid.',
            'position.required' => 'Jabatan/posisi wajib diisi.',
            'unit_id.required' => 'Unit/Fakultas wajib dipilih.',
            'unit_id.exists' => 'Unit/Fakultas tidak ditemukan.',
            'sk_file.mimes' => 'File SK harus berformat PDF, JPG, atau PNG.',
            'sk_file.max' => 'Ukuran file SK maksimal 2MB.',
        ]);

        // Hapus pengajuan lama yang ditolak (jika ada) sebelum buat baru
        RoleRequest::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->delete();

        // Upload SK jika ada
        $skPath = null;
        $skOriginalName = null;
        if ($request->hasFile('sk_file')) {
            $file = $request->file('sk_file');
            $skOriginalName = $file->getClientOriginalName();
            $skPath = $file->store('sk_files', 'public');
        }

        $roleRequest = RoleRequest::create([
            'user_id' => $user->id,
            'requested_role' => $validated['requested_role'],
            'position' => $validated['position'],
            'unit_id' => $validated['unit_id'],
            'sk_file' => $skPath,
            'sk_original_name' => $skOriginalName,
            'status' => 'pending',
        ]);

        $this->log(null, 'Mengajukan permintaan role: ' . $validated['requested_role']);

        // Send notification to Super Admins
        $superAdmins = User::role('Super Admin')->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new RoleRequestSubmitted($roleRequest));
        }

        return redirect()->route('role-request.create')
            ->with('success', 'Pengajuan role berhasil dikirim! Silakan tunggu persetujuan admin.');
    }

    /**
     * Daftar semua pengajuan (untuk Super Admin).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $roleRequests = RoleRequest::with(['user', 'unit', 'reviewer'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        $counts = [
            'pending' => RoleRequest::pending()->count(),
            'approved' => RoleRequest::approved()->count(),
            'rejected' => RoleRequest::rejected()->count(),
            'all' => RoleRequest::count(),
        ];

        return view('role-requests.index', compact('roleRequests', 'status', 'counts'));
    }

    /**
     * Setujui pengajuan role.
     */
    public function approve(RoleRequest $roleRequest)
    {
        if (!$roleRequest->isPending()) {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        // Assign role ke user
        $user = $roleRequest->user;
        $user->syncRoles([$roleRequest->requested_role]);

        // Update unit_id user jika belum ada
        if (!$user->unit_id) {
            $user->update(['unit_id' => $roleRequest->unit_id]);
        }

        // Update status pengajuan
        $roleRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $this->log(null, 'Menyetujui pengajuan role ' . $roleRequest->requested_role . ' untuk user ' . $user->name);

        // Notify User
        $user->notify(new \App\Notifications\RoleRequestStatusUpdated($roleRequest, 'Pengajuan hak akses Anda sebagai ' . $roleRequest->requested_role . ' telah DISETUJUI.'));

        return back()->with('success', "Pengajuan {$user->name} sebagai {$roleRequest->requested_role} telah disetujui.");
    }

    /**
     * Tolak pengajuan role.
     */
    public function reject(Request $request, RoleRequest $roleRequest)
    {
        if (!$roleRequest->isPending()) {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $roleRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $this->log(null, 'Menolak pengajuan role ' . $roleRequest->requested_role . ' untuk user ' . $roleRequest->user->name . '. Alasan: ' . $request->rejection_reason);

        // Notify User
        $roleRequest->user->notify(new \App\Notifications\RoleRequestStatusUpdated($roleRequest, 'Pengajuan hak akses Anda sebagai ' . $roleRequest->requested_role . ' DITOLAK. Alasan: ' . $request->rejection_reason));

        return back()->with('success', "Pengajuan {$roleRequest->user->name} telah ditolak.");
    }
}
