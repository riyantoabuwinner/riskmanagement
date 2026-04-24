<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Traits\HasAuditLog;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Exports\UserTemplateExport;

class UserController extends Controller
{
    use HasAuditLog;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('manage users');
        $search = $request->input('search');
        
        $users = User::with(['unit', 'roles'])
            ->when($search, function($query, $search) {
                $terms = explode(' ', $search);
                return $query->where(function($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->where(function($sub) use ($term) {
                            $sub->where('name', 'like', "%{$term}%")
                                ->orWhere('email', 'like', "%{$term}%")
                                ->orWhereHas('unit', function($u) use ($term) {
                                    $u->where('nama_unit', 'like', "%{$term}%");
                                })
                                ->orWhereHas('roles', function($r) use ($term) {
                                    $r->where('name', 'like', "%{$term}%");
                                });
                        });
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        $this->authorize('manage users');
        $units = \App\Models\Unit::all();
        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.create', compact('units', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage users');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'unit_id' => 'nullable|exists:units,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'unit_id' => $validated['unit_id'],
        ]);

        $user->assignRole($validated['role']);

        $this->log(null, 'Membuat user baru: ' . $user->name . ' dengan role ' . $validated['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $units = \App\Models\Unit::all();
        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.edit', compact('user', 'units', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'unit_id' => 'nullable|exists:units,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'unit_id' => $validated['unit_id'],
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);
        $user->syncRoles([$validated['role']]);

        $this->log(null, 'Memperbarui data user: ' . $user->name);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $userName = $user->name;
        $user->delete();

        $this->log(null, 'Menghapus user: ' . $userName);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function import(Request $request)
    {
        $this->authorize('manage users');
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new UserImport, $request->file('file'));
            $this->log(null, 'Melakukan import pengguna dari Excel');
            return back()->with('success', 'Data pengguna berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $this->authorize('manage users');
        return Excel::download(new UserTemplateExport, 'Format_Import_Pengguna.xlsx');
    }

    public function bulkDelete(Request $request)
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Hanya Super Admin yang dapat menghapus pengguna.');
        }
        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        // Prevent self-deletion
        if (in_array(auth()->id(), $ids)) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $count = count($ids);
        User::whereIn('id', $ids)->delete();
        $this->log(null, 'Menghapus masal ' . $count . ' pengguna');
        
        return back()->with('success', $count . ' pengguna berhasil dihapus.');
    }
}
