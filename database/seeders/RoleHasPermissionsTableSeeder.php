<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_has_permissions')->delete();
        
        \DB::table('role_has_permissions')->insert(array (
            0 => 
            array (
                'permission_id' => 1,
                'role_id' => 1,
            ),
            1 => 
            array (
                'permission_id' => 1,
                'role_id' => 2,
            ),
            2 => 
            array (
                'permission_id' => 1,
                'role_id' => 3,
            ),
            3 => 
            array (
                'permission_id' => 1,
                'role_id' => 4,
            ),
            4 => 
            array (
                'permission_id' => 1,
                'role_id' => 5,
            ),
            5 => 
            array (
                'permission_id' => 2,
                'role_id' => 1,
            ),
            6 => 
            array (
                'permission_id' => 2,
                'role_id' => 2,
            ),
            7 => 
            array (
                'permission_id' => 2,
                'role_id' => 3,
            ),
            8 => 
            array (
                'permission_id' => 3,
                'role_id' => 1,
            ),
            9 => 
            array (
                'permission_id' => 3,
                'role_id' => 2,
            ),
            10 => 
            array (
                'permission_id' => 3,
                'role_id' => 3,
            ),
            11 => 
            array (
                'permission_id' => 4,
                'role_id' => 1,
            ),
            12 => 
            array (
                'permission_id' => 4,
                'role_id' => 2,
            ),
            13 => 
            array (
                'permission_id' => 4,
                'role_id' => 5,
            ),
            14 => 
            array (
                'permission_id' => 5,
                'role_id' => 1,
            ),
            15 => 
            array (
                'permission_id' => 5,
                'role_id' => 2,
            ),
            16 => 
            array (
                'permission_id' => 5,
                'role_id' => 3,
            ),
            17 => 
            array (
                'permission_id' => 5,
                'role_id' => 4,
            ),
            18 => 
            array (
                'permission_id' => 6,
                'role_id' => 1,
            ),
            19 => 
            array (
                'permission_id' => 6,
                'role_id' => 2,
            ),
            20 => 
            array (
                'permission_id' => 6,
                'role_id' => 3,
            ),
            21 => 
            array (
                'permission_id' => 6,
                'role_id' => 4,
            ),
            22 => 
            array (
                'permission_id' => 7,
                'role_id' => 1,
            ),
            23 => 
            array (
                'permission_id' => 7,
                'role_id' => 2,
            ),
            24 => 
            array (
                'permission_id' => 7,
                'role_id' => 3,
            ),
            25 => 
            array (
                'permission_id' => 8,
                'role_id' => 1,
            ),
            26 => 
            array (
                'permission_id' => 8,
                'role_id' => 2,
            ),
            27 => 
            array (
                'permission_id' => 8,
                'role_id' => 3,
            ),
            28 => 
            array (
                'permission_id' => 9,
                'role_id' => 1,
            ),
            29 => 
            array (
                'permission_id' => 9,
                'role_id' => 2,
            ),
            30 => 
            array (
                'permission_id' => 9,
                'role_id' => 3,
            ),
            31 => 
            array (
                'permission_id' => 9,
                'role_id' => 4,
            ),
            32 => 
            array (
                'permission_id' => 9,
                'role_id' => 5,
            ),
            33 => 
            array (
                'permission_id' => 10,
                'role_id' => 1,
            ),
            34 => 
            array (
                'permission_id' => 10,
                'role_id' => 2,
            ),
            35 => 
            array (
                'permission_id' => 10,
                'role_id' => 3,
            ),
            36 => 
            array (
                'permission_id' => 10,
                'role_id' => 4,
            ),
            37 => 
            array (
                'permission_id' => 10,
                'role_id' => 5,
            ),
            38 => 
            array (
                'permission_id' => 11,
                'role_id' => 1,
            ),
            39 => 
            array (
                'permission_id' => 11,
                'role_id' => 2,
            ),
            40 => 
            array (
                'permission_id' => 11,
                'role_id' => 3,
            ),
            41 => 
            array (
                'permission_id' => 11,
                'role_id' => 4,
            ),
            42 => 
            array (
                'permission_id' => 12,
                'role_id' => 1,
            ),
            43 => 
            array (
                'permission_id' => 12,
                'role_id' => 2,
            ),
            44 => 
            array (
                'permission_id' => 12,
                'role_id' => 3,
            ),
            45 => 
            array (
                'permission_id' => 13,
                'role_id' => 1,
            ),
            46 => 
            array (
                'permission_id' => 13,
                'role_id' => 2,
            ),
            47 => 
            array (
                'permission_id' => 14,
                'role_id' => 1,
            ),
            48 => 
            array (
                'permission_id' => 15,
                'role_id' => 1,
            ),
            49 => 
            array (
                'permission_id' => 16,
                'role_id' => 1,
            ),
            50 => 
            array (
                'permission_id' => 17,
                'role_id' => 1,
            ),
        ));
        
        
    }
}