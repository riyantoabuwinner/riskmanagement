<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'view dashboard',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'manage master data',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'manage units',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'create risks',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'view all risks',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'review risks',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'approve risks',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'approve evaluations',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'manage mitigations',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'monitor risks',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'view reports',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'generate executive report',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'export reports',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'manage users',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'view audit logs',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'manage role requests',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'manage backups',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
        ));
        
        
    }
}