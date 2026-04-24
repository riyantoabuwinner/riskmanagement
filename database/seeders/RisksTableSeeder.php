<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RisksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('risks')->delete();
        
        \DB::table('risks')->insert(array (
            0 => 
            array (
                'id' => 2,
                'kode_risiko' => 'ICT-001',
                'nomor_urut' => 1,
                'unit_id' => 27,
                'kategori_id' => 6,
                'misi_universitas' => NULL,
            'nama_risiko' => 'Kegagalan Sistem Informasi Akademik (SIAKAD) pada Masa KRS',
            'sasaran_strategis' => '[IKU-TIK-1] Persentase ketersediaan layanan sistem informasi utama (SIAKAD, LMS, WEB)',
                'deskripsi' => 'Server tidak mampu menangani lonjakan traffic saat periode pengisian KRS serentak.',
                'penyebab' => 'Kapasitas RAM dan CPU server terbatas, serta belum adanya load balancing.',
                'dampak' => 'Mahasiswa tidak bisa mengisi KRS, jadwal akademik terganggu, dan keluhan publik meningkat.',
                'probabilitas' => 4,
                'level_dampak' => 5,
                'skor_risiko' => 20,
                'level_risiko' => 'Extreme',
                'pemilik_risiko' => NULL,
                'status' => 'Approved',
                'rejection_reason' => NULL,
                'catatan_evaluasi' => 'Risiko ini sangat kritis karena berdampak langsung pada layanan utama universitas.',
                'tanggal_identifikasi' => '2026-04-22',
                'created_by' => 271,
                'created_at' => '2026-04-22 23:00:56',
                'updated_at' => '2026-04-22 23:08:08',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'kode_risiko' => 'ICT-002',
                'nomor_urut' => 2,
                'unit_id' => 27,
                'kategori_id' => 6,
                'misi_universitas' => NULL,
                'nama_risiko' => 'Potensi Serangan Ransomware pada Database Kepegawaian',
            'sasaran_strategis' => '[IKU-TIK-2] Indeks Kematangan Keamanan Siber (CSIRT)',
                'deskripsi' => 'Ditemukan celah keamanan pada sistem operasi server database yang belum di-patch.',
                'penyebab' => 'Kurangnya jadwal maintenance rutin dan keterbatasan personil IT security.',
                'dampak' => 'Seluruh data kepegawaian terkunci, layanan administrasi lumpuh total.',
                'probabilitas' => 3,
                'level_dampak' => 3,
                'skor_risiko' => 9,
                'level_risiko' => 'Medium',
                'pemilik_risiko' => NULL,
                'status' => 'Approved',
                'rejection_reason' => NULL,
                'catatan_evaluasi' => 'Seringnya terjadi serangan malware yang masif',
                'tanggal_identifikasi' => '2026-04-22',
                'created_by' => 271,
                'created_at' => '2026-04-22 23:09:42',
                'updated_at' => '2026-04-23 00:00:09',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}