<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            // Fakultas & Dekanat
            ['nama_unit' => 'Dekanat Fakultas Ilmu Tarbiyah dan Keguruan', 'jenis_unit' => 'Fakultas', 'pimpinan' => 'Dekan FITK'],
            ['nama_unit' => 'Dekanat Fakultas Syariah', 'jenis_unit' => 'Fakultas', 'pimpinan' => 'Dekan FS'],
            ['nama_unit' => 'Dekanat Fakultas Ushuluddin Adab dan Dakwah', 'jenis_unit' => 'Fakultas', 'pimpinan' => 'Dekan FUAD'],

            // Prodi (Sample)
            ['nama_unit' => 'Prodi Teknik Informatika', 'jenis_unit' => 'Program Studi', 'pimpinan' => 'Kaprodi TI'],
            ['nama_unit' => 'Prodi Sistem Informasi', 'jenis_unit' => 'Program Studi', 'pimpinan' => 'Kaprodi SI'],

            // Biro & Lembaga
            ['nama_unit' => 'Biro Administrasi Umum, Perencanaan dan Keuangan', 'jenis_unit' => 'Biro', 'pimpinan' => 'Kabiro AUPK'],
            ['nama_unit' => 'Lembaga Penjaminan Mutu', 'jenis_unit' => 'Lembaga', 'pimpinan' => 'Ketua LPM'],
            ['nama_unit' => 'Satuan Pengawas Internal', 'jenis_unit' => 'Lembaga', 'pimpinan' => 'Ketua SPI'],
        ];

        foreach ($units as $unit) {
            $jenis = $unit['jenis_unit'];
            unset($unit['jenis_unit']);
            
            $unitType = \App\Models\UnitType::where('nama_jenis', $jenis)->first();
            if ($unitType) {
                $unit['unit_type_id'] = $unitType->id;
            }

            \App\Models\Unit::firstOrCreate(['nama_unit' => $unit['nama_unit']], $unit);
        }
    }
}
