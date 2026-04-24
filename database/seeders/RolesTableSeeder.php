<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Risk Manager',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Risk Officer',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Risk Owner',
                'guard_name' => 'web',
                'created_at' => '2026-04-06 04:52:17',
                'updated_at' => '2026-04-06 04:52:17',
            ),
        ));
        
        
    }
}