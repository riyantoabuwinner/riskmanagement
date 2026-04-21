<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Traits\HasAuditLog;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasAuditLog;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('manage users');
        $users = User::with('unit')->paginate(10);
        return view('users.index', compact('users'));
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
        $userName = $user->name;
        $user->delete();

        $this->log(null, 'Menghapus user: ' . $userName);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
