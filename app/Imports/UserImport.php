<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Spatie\Permission\Models\Role;

class UserImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $unit = Unit::where('nama_unit', 'like', '%' . $row['unit_kerja'] . '%')->first();
        
        $user = User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name'     => $row['nama'],
                'password' => Hash::make($row['password'] ?? 'password123'),
                'unit_id'  => $unit ? $unit->id : null,
            ]
        );

        if (!empty($row['role'])) {
            $role = Role::where('name', $row['role'])->first();
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }

        return $user;
    }

    public function rules(): array
    {
        return [
            'nama'  => 'required|string|max:255',
            'email' => 'required|email',
            'role'  => 'required|string',
        ];
    }
}
