<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('silenthustle');

        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@uinssc.ac.id'],
            [
                'name' => 'Super Admin',
                'password' => $password,
                'unit_id' => null,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // 2. Admin Universitas
        $adminUniv = User::updateOrCreate(
            ['email' => 'admin_univ@uinssc.ac.id'],
            [
                'name' => 'Admin Universitas',
                'password' => $password,
                'unit_id' => null,
            ]
        );
        $adminUniv->syncRoles(['Admin']);

        // 3. Users for each Unit
        $units = Unit::all();
        $roles = ['Risk Manager', 'Risk Officer', 'Risk Owner'];

        foreach ($units as $unit) {
            foreach ($roles as $roleName) {
                $roleSlug = Str::slug($roleName, '_');
                $unitSlug = Str::slug($unit->nama_unit, '_');
                $email = "{$roleSlug}_{$unitSlug}";
                
                // Limit email prefix length if necessary
                $email = substr($email, 0, 45) . '@uinssc.ac.id';

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $roleName . ' - ' . $unit->nama_unit,
                        'password' => $password,
                        'unit_id' => $unit->id,
                    ]
                );
                $user->syncRoles([$roleName]);
            }
        }
    }
}
