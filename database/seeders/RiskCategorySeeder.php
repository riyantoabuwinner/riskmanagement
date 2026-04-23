<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['kode' => 'STR', 'nama_kategori' => 'Risiko Strategis', 'deskripsi' => 'Risiko yang mempengaruhi pencapaian visi dan misi universitas'],
            ['kode' => 'OPR', 'nama_kategori' => 'Risiko Operasional', 'deskripsi' => 'Risiko pada proses bisnis harian, SDM, dan infrastruktur'],
            ['kode' => 'FIN', 'nama_kategori' => 'Risiko Keuangan', 'deskripsi' => 'Risiko pengelolaan anggaran PNBP/BLU dan aset'],
            ['kode' => 'CPL', 'nama_kategori' => 'Risiko Kepatuhan', 'deskripsi' => 'Risiko pelanggaran regulasi pendidikan tinggi'],
            ['kode' => 'REP', 'nama_kategori' => 'Risiko Reputasi', 'deskripsi' => 'Risiko yang menurunkan kepercayaan publik terhadap UIN'],
            ['kode' => 'ICT', 'nama_kategori' => 'Risiko TI', 'deskripsi' => 'Risiko keamanan data dan kegagalan sistem informasi siber'],
        ];

        foreach ($categories as $cat) {
            \App\Models\RiskCategory::updateOrCreate(
                ['nama_kategori' => $cat['nama_kategori']],
                $cat
            );
        }
    }
}
