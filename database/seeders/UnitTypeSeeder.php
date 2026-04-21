<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['nama_jenis' => 'Fakultas', 'deskripsi' => 'Unit kerja tingkat fakultas'],
            ['nama_jenis' => 'Lembaga', 'deskripsi' => 'Unit kerja tingkat lembaga'],
            ['nama_jenis' => 'Unit Pelaksana Teknis', 'deskripsi' => 'Unit Pelaksana Teknis (UPT)'],
            ['nama_jenis' => 'Biro', 'deskripsi' => 'Unit kerja administrasi pusat'],
            ['nama_jenis' => 'Pusat', 'deskripsi' => 'Pusat studi atau layanan'],
        ];

        foreach ($types as $type) {
            \App\Models\UnitType::updateOrCreate(['nama_jenis' => $type['nama_jenis']], $type);
        }
    }
}
