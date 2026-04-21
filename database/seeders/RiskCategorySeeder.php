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
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko Strategis', 'deskripsi' => 'Risiko yang mempengaruhi pencapaian visi dan misi universitas']);
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko Operasional', 'deskripsi' => 'Risiko pada proses bisnis harian, SDM, dan infrastruktur']);
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko Keuangan', 'deskripsi' => 'Risiko pengelolaan anggaran PNBP/BLU dan aset']);
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko Kepatuhan', 'deskripsi' => 'Risiko pelanggaran regulasi pendidikan tinggi']);
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko Reputasi', 'deskripsi' => 'Risiko yang menurunkan kepercayaan publik terhadap UIN']);
        \App\Models\RiskCategory::create(['nama_kategori' => 'Risiko TI', 'deskripsi' => 'Risiko keamanan data dan kegagalan sistem informasi siber']);
    }
}
