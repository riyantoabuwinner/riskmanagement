<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\Mitigation;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitigationController extends Controller
{
    use HasAuditLog;
    /**
     * Tampilkan daftar rencana mitigasi
     */
    public function index()
    {
        $this->authorize('viewAny', Mitigation::class);

        $query = Mitigation::with(['risk.unit', 'risk.kategori']);

        // Filter by Unit for non-admin
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $unitId = Auth::user()->unit_id;
            $query->whereHas('risk', function ($q) use ($unitId) {
                $q->where('unit_id', $unitId);
            });
        }

        $mitigations = $query->latest()->paginate(15);

        return view('mitigations.index', compact('mitigations'));
    }

    /**
     * Form tambah mitigasi khusus untuk risiko tertentu
     */
    public function create(Request $request)
    {
        $this->authorize('create', Mitigation::class);

        $riskId = $request->query('risk_id');
        $risk = Risk::findOrFail($riskId);

        // Security check: risk must be approved to have mitigations? 
        // Or at least must belong to user unit if not admin
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager']) && $risk->unit_id !== Auth::user()->unit_id) {
            abort(403);
        }

        return view('mitigations.create', compact('risk'));
    }

    /**
     * Simpan rencana mitigasi baru
     */
    public function store(Request $request)
    {
        $this->authorize('create', Mitigation::class);

        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'strategi' => 'required|in:Hindari,Mitigasi,Transfer,Terima',
            'rencana_aksi' => 'required|string|min:5',
            'penanggung_jawab' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'target_waktu' => 'required|date|after_or_equal:tanggal_mulai',
            'anggaran' => 'nullable|numeric|min:0',
        ]);

        $validated['anggaran'] = $validated['anggaran'] ?? 0;

        Mitigation::create($validated);

        $this->log($validated['risk_id'], 'Menambahkan rencana mitigasi baru');

        return redirect()->route('risks.show', $validated['risk_id'])
            ->with('success', 'Rencana mitigasi berhasil ditambahkan.');
    }

    /**
     * Update status mitigasi
     */
    public function update(Request $request, Mitigation $mitigation)
    {
        $this->authorize('update', $mitigation);

        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $mitigation->update($validated);

        $this->log($mitigation->risk_id, 'Memperbarui status mitigasi menjadi: ' . $validated['status']);

        return back()->with('success', 'Status mitigasi berhasil diperbarui.');
    }

    /**
     * Hapus mitigasi
     */
    public function destroy(Mitigation $mitigation)
    {
        $this->authorize('delete', $mitigation);

        $riskId = $mitigation->risk_id;
        $mitigation->delete();

        $this->log($riskId, 'Menghapus rencana mitigasi');

        return redirect()->route('risks.show', $riskId)
            ->with('success', 'Rencana mitigasi berhasil dihapus.');
    }
}
