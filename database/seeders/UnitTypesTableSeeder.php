<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('unit_types')->delete();
        
        \DB::table('unit_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_jenis' => 'Fakultas',
                'deskripsi' => 'Unit kerja tingkat fakultas',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-06 05:03:59',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_jenis' => 'Lembaga',
                'deskripsi' => 'Unit kerja tingkat lembaga',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-06 05:03:59',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_jenis' => 'Unit Pelaksana Teknis',
            'deskripsi' => 'Unit Pelaksana Teknis (UPT)',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-06 05:03:59',
            ),
            3 => 
            array (
                'id' => 4,
                'nama_jenis' => 'Biro',
                'deskripsi' => 'Unit kerja administrasi pusat',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-06 05:03:59',
            ),
            4 => 
            array (
                'id' => 5,
                'nama_jenis' => 'Pusat',
                'deskripsi' => 'Pusat studi atau layanan',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-06 05:03:59',
            ),
            5 => 
            array (
                'id' => 6,
                'nama_jenis' => 'Program Studi',
                'deskripsi' => 'Unit kerja tingkat program studi',
                'created_at' => '2026-04-08 21:42:03',
                'updated_at' => '2026-04-08 23:10:18',
            ),
        ));
        
        
    }
}