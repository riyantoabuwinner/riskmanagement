<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RiskMonitoringTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('risk_monitoring')->delete();
        
        \DB::table('risk_monitoring')->insert(array (
            0 => 
            array (
                'id' => 1,
                'risk_id' => 2,
                'progress' => 75,
                'catatan' => 'Setelah implementasi penjadwalan angkatan, beban server berkurang signifikan. Namun upgrade infrastruktur masih dalam tahap pengadaan.',
                'residual_probabilitas' => 2,
                'residual_impact' => 3,
                'residual_score' => 6,
                'residual_level' => 'Medium',
                'tanggal_update' => '2026-04-22',
                'created_at' => '2026-04-22 23:08:08',
                'updated_at' => '2026-04-22 23:08:08',
            ),
            1 => 
            array (
                'id' => 2,
                'risk_id' => 2,
                'progress' => 75,
                'catatan' => 'Cukup efektif',
                'residual_probabilitas' => 2,
                'residual_impact' => 3,
                'residual_score' => 6,
                'residual_level' => 'Medium',
                'tanggal_update' => '2026-04-23',
                'created_at' => '2026-04-23 22:56:02',
                'updated_at' => '2026-04-23 22:56:02',
            ),
            2 => 
            array (
                'id' => 3,
                'risk_id' => 2,
                'progress' => 75,
                'catatan' => 'Efektif',
                'residual_probabilitas' => 2,
                'residual_impact' => 3,
                'residual_score' => 6,
                'residual_level' => 'Medium',
                'tanggal_update' => '2026-04-23',
                'created_at' => '2026-04-23 22:56:55',
                'updated_at' => '2026-04-23 22:56:55',
            ),
            3 => 
            array (
                'id' => 4,
                'risk_id' => 2,
                'progress' => 75,
                'catatan' => 'Cukup efektif',
                'residual_probabilitas' => 2,
                'residual_impact' => 3,
                'residual_score' => 6,
                'residual_level' => 'Medium',
                'tanggal_update' => '2026-04-23',
                'created_at' => '2026-04-23 22:58:47',
                'updated_at' => '2026-04-23 22:58:47',
            ),
            4 => 
            array (
                'id' => 5,
                'risk_id' => 2,
                'progress' => 75,
                'catatan' => 'Cukup efektif',
                'residual_probabilitas' => 2,
                'residual_impact' => 3,
                'residual_score' => 6,
                'residual_level' => 'Medium',
                'tanggal_update' => '2026-04-23',
                'created_at' => '2026-04-23 23:00:10',
                'updated_at' => '2026-04-23 23:00:10',
            ),
            5 => 
            array (
                'id' => 6,
                'risk_id' => 3,
                'progress' => 0,
                'catatan' => 'Belum dimulai',
                'residual_probabilitas' => NULL,
                'residual_impact' => NULL,
                'residual_score' => NULL,
                'residual_level' => NULL,
                'tanggal_update' => '2026-04-23',
                'created_at' => '2026-04-23 23:00:46',
                'updated_at' => '2026-04-23 23:00:46',
            ),
        ));
        
        
    }
}