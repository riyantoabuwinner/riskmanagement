<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MitigationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mitigations')->delete();
        
        \DB::table('mitigations')->insert(array (
            0 => 
            array (
                'id' => 2,
                'risk_id' => 2,
                'strategi' => 'Upgrade Infrastruktur Cloud & Implementasi Load Balancing',
                'rencana_aksi' => 'Melakukan upgrade kapasitas server sementara selama masa KRS dan memasang sistem load balancing untuk membagi traffic.',
                'penanggung_jawab' => 'Koordinator Infrastruktur TI',
                'tanggal_mulai' => NULL,
                'target_waktu' => '2026-06-22',
                'anggaran' => '25000000.00',
                'status' => 'On Progress',
                'created_at' => '2026-04-22 23:01:24',
                'updated_at' => '2026-04-22 23:08:08',
            ),
            1 => 
            array (
                'id' => 3,
                'risk_id' => 2,
                'strategi' => 'Penjadwalan KRS Berbasis Angkatan',
                'rencana_aksi' => 'Membagi jadwal akses login SIAKAD berdasarkan angkatan untuk mengurangi beban traffic simultan.',
                'penanggung_jawab' => 'Bagian Akademik & TIK',
                'tanggal_mulai' => NULL,
                'target_waktu' => '2026-05-06',
                'anggaran' => '0.00',
                'status' => 'Completed',
                'created_at' => '2026-04-22 23:01:24',
                'updated_at' => '2026-04-22 23:08:08',
            ),
        ));
        
        
    }
}