<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view dashboard',
            'manage master data',
            'manage units',
            'create risks',
            'view all risks',
            'review risks',
            'approve risks',
            'approve evaluations',
            'manage mitigations',
            'monitor risks',
            'view reports',
            'generate executive report',
            'export reports',
            'manage users',
            'view audit logs',
            'manage role requests',
            'manage backups',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 1) Super Admin
        $roleSuperAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $roleSuperAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // 2) Admin
        $roleAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $roleAdmin->givePermissionTo([
            'view dashboard',
            'manage master data',
            'manage units',
            'view all risks',
            'review risks',
            'approve risks',
            'approve evaluations',
            'manage mitigations',
            'monitor risks',
            'view reports',
            'generate executive report',
            'export reports',
            'create risks',
        ]);

        // 3) Risk Manager
        $roleRiskManager = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Risk Manager', 'guard_name' => 'web']);
        $roleRiskManager->givePermissionTo([
            'view dashboard',
            'manage master data',
            'manage units',
            'view all risks',
            'review risks',
            'approve risks',
            'approve evaluations',
            'manage mitigations',
            'monitor risks',
            'view reports',
            'generate executive report'
        ]);

        // 4) Risk Officer
        $roleRiskOfficer = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Risk Officer', 'guard_name' => 'web']);
        $roleRiskOfficer->givePermissionTo([
            'view dashboard',
            'view all risks',
            'review risks', // Analisis & evaluasi
            'manage mitigations',
            'monitor risks',
            'view reports'
        ]);

        // 5) Risk Owner
        $roleRiskOwner = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Risk Owner', 'guard_name' => 'web']);
        $roleRiskOwner->givePermissionTo([
            'view dashboard',
            'create risks', // Input risiko unit kerja
            'manage mitigations', // Update status mitigasi
            'monitor risks'
        ]);
    }
}
