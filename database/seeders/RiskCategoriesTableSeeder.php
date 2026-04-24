<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RiskCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('risk_categories')->delete();
        
        \DB::table('risk_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kode' => 'STR',
                'nama_kategori' => 'Risiko Strategis',
                'deskripsi' => 'Risiko yang mempengaruhi pencapaian visi dan misi universitas',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
            1 => 
            array (
                'id' => 2,
                'kode' => 'OPR',
                'nama_kategori' => 'Risiko Operasional',
                'deskripsi' => 'Risiko pada proses bisnis harian, SDM, dan infrastruktur',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
            2 => 
            array (
                'id' => 3,
                'kode' => 'FIN',
                'nama_kategori' => 'Risiko Keuangan',
                'deskripsi' => 'Risiko pengelolaan anggaran PNBP/BLU dan aset',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
            3 => 
            array (
                'id' => 4,
                'kode' => 'CPL',
                'nama_kategori' => 'Risiko Kepatuhan',
                'deskripsi' => 'Risiko pelanggaran regulasi pendidikan tinggi',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
            4 => 
            array (
                'id' => 5,
                'kode' => 'REP',
                'nama_kategori' => 'Risiko Reputasi',
                'deskripsi' => 'Risiko yang menurunkan kepercayaan publik terhadap UIN',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
            5 => 
            array (
                'id' => 6,
                'kode' => 'ICT',
                'nama_kategori' => 'Risiko TI',
                'deskripsi' => 'Risiko keamanan data dan kegagalan sistem informasi siber',
                'created_at' => '2026-04-06 05:03:59',
                'updated_at' => '2026-04-22 22:07:18',
            ),
        ));
        
        
    }
}