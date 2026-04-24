<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PerformanceIndicatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('performance_indicators')->delete();
        
        \DB::table('performance_indicators')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'code' => 'PROTAS-1',
                'name' => 'Meningkatkan Kerukunan dan Cinta Kemanusiaan',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => NULL,
                'code' => 'PROTAS-2',
                'name' => 'Penguatan Ekoteologi',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => NULL,
                'code' => 'PROTAS-3',
                'name' => 'Layanan Keagamaan Berdampak',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => NULL,
                'code' => 'PROTAS-4',
                'name' => 'Pendidikan Unggul, Ramah & Terintegrasi',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => NULL,
                'code' => 'PROTAS-5',
                'name' => 'Pemberdayaan Pesantren',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => NULL,
                'code' => 'PROTAS-6',
                'name' => 'Pemberdayaan Ekonomi Umat',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => NULL,
                'code' => 'PROTAS-7',
                'name' => 'Sukses Haji',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => NULL,
                'code' => 'PROTAS-8',
                'name' => 'Digitalisasi Tata Kelola',
                'type' => 'ASTA PROTAS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:10:51',
                'updated_at' => '2026-04-08 16:10:51',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => NULL,
                'code' => 'IKU-1',
                'name' => 'Lulusan mendapatkan pekerjaan yang layak',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => NULL,
                'code' => 'IKU-2',
                'name' => 'Mahasiswa mendapat pengalaman di luar kampus',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => NULL,
                'code' => 'IKU-3',
                'name' => 'Dosen berkegiatan di luar kampus',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => NULL,
                'code' => 'IKU-4',
                'name' => 'Praktisi mengajar di dalam kampus',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => NULL,
                'code' => 'IKU-5',
                'name' => 'Hasil kerja dosen digunakan oleh masyarakat',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => NULL,
                'code' => 'IKU-6',
                'name' => 'Program studi bekerjasama dengan mitra kelas dunia',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => NULL,
                'code' => 'IKU-7',
                'name' => 'Kelas yang kolaboratif dan partisipatif',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => NULL,
                'code' => 'IKU-8',
                'name' => 'Program studi berstandar Internasional',
                'type' => 'IKU PTN',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => NULL,
                'code' => 'SP.7',
                'name' => 'Meningkatnya Kualitas Standar dan Sistem Penjaminan Mutu',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 17,
                'code' => 'IKSP.7.2',
                'name' => 'Persentase PTK Islam yang terakreditasi',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => NULL,
                'code' => 'SP.8',
                'name' => 'Meningkatnya Dosen dan Tenaga Kependidikan yang Berkualitas',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 19,
                'code' => 'IKSP.8.2',
                'name' => 'Persentase dosen dan tenaga kependidikan PTK Islam yang memperoleh sertifikasi peningkatan kompetensi',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => NULL,
                'code' => 'SP.9',
                'name' => 'Meningkatnya Daya Saing Lulusan pada PTK',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 21,
                'code' => 'IKSP.9.1',
                'name' => 'Rata-rata masa tunggu lulusan PTK Islam untuk mendapatkan pekerjaan',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            22 => 
            array (
                'id' => 23,
                'parent_id' => NULL,
                'code' => 'SP.10',
                'name' => 'Meningkatnya Relevansi PTK melalui Penguatan Kemitraan Strategis',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            23 => 
            array (
                'id' => 24,
                'parent_id' => 23,
                'code' => 'IKSP.10.1',
                'name' => 'Persentase kerja sama aktif yang menghasilkan program peningkatan mutu PTK Islam',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            24 => 
            array (
                'id' => 25,
                'parent_id' => NULL,
                'code' => 'SP.11',
                'name' => 'Meningkatnya Kualitas Karakter Keagamaan Mahasiswa yang ramah, Inklusif, dan Selaras dengan Nilai-nilai Kebangsaan',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            25 => 
            array (
                'id' => 26,
                'parent_id' => 25,
                'code' => 'IKSP.11.1',
                'name' => 'Indeks Keberagamaan Mahasiswa Islam',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            26 => 
            array (
                'id' => 27,
                'parent_id' => NULL,
                'code' => 'SP.12',
                'name' => 'Meningkatnya Produktivitas dan Daya Saing Perguruan Tinggi Keagamaan',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            27 => 
            array (
                'id' => 28,
                'parent_id' => 27,
                'code' => 'IKSP.12.1',
                'name' => 'Jumlah perguruan tinggi keagamaan Islam yang masuk ke dalam peringkat THE Impact SDGs',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            28 => 
            array (
                'id' => 29,
                'parent_id' => NULL,
                'code' => 'SP.13',
                'name' => 'Meningkatnya Tata Kelola Organisasi yang Efektif dan Akuntabel',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            29 => 
            array (
                'id' => 30,
                'parent_id' => 29,
                'code' => 'IKSP.13.2',
            'name' => 'Nilai Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) UIN SSC',
                'type' => 'PERKIN PENDIS',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            30 => 
            array (
                'id' => 31,
                'parent_id' => NULL,
                'code' => 'SDG-1',
                'name' => 'Tanpa Kemiskinan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            31 => 
            array (
                'id' => 32,
                'parent_id' => NULL,
                'code' => 'SDG-2',
                'name' => 'Tanpa Kelaparan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            32 => 
            array (
                'id' => 33,
                'parent_id' => NULL,
                'code' => 'SDG-3',
                'name' => 'Kehidupan Sehat dan Sejahtera',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            33 => 
            array (
                'id' => 34,
                'parent_id' => NULL,
                'code' => 'SDG-4',
                'name' => 'Pendidikan Berkualitas',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            34 => 
            array (
                'id' => 35,
                'parent_id' => NULL,
                'code' => 'SDG-5',
                'name' => 'Kesetaraan Gender',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            35 => 
            array (
                'id' => 36,
                'parent_id' => NULL,
                'code' => 'SDG-6',
                'name' => 'Air Bersih dan Sanitasi Layak',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            36 => 
            array (
                'id' => 37,
                'parent_id' => NULL,
                'code' => 'SDG-7',
                'name' => 'Energi Bersih dan Terjangkau',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            37 => 
            array (
                'id' => 38,
                'parent_id' => NULL,
                'code' => 'SDG-8',
                'name' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            38 => 
            array (
                'id' => 39,
                'parent_id' => NULL,
                'code' => 'SDG-9',
                'name' => 'Industri, Inovasi, dan Infrastruktur',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            39 => 
            array (
                'id' => 40,
                'parent_id' => NULL,
                'code' => 'SDG-10',
                'name' => 'Berkurangnya Kesenjangan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            40 => 
            array (
                'id' => 41,
                'parent_id' => NULL,
                'code' => 'SDG-11',
                'name' => 'Kota dan Permukiman yang Berkelanjutan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            41 => 
            array (
                'id' => 42,
                'parent_id' => NULL,
                'code' => 'SDG-12',
                'name' => 'Konsumsi dan Produksi yang Bertanggung Jawab',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            42 => 
            array (
                'id' => 43,
                'parent_id' => NULL,
                'code' => 'SDG-13',
                'name' => 'Penanganan Perubahan Iklim',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            43 => 
            array (
                'id' => 44,
                'parent_id' => NULL,
                'code' => 'SDG-14',
                'name' => 'Ekosistem Lautan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            44 => 
            array (
                'id' => 45,
                'parent_id' => NULL,
                'code' => 'SDG-15',
                'name' => 'Ekosistem Daratan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            45 => 
            array (
                'id' => 46,
                'parent_id' => NULL,
                'code' => 'SDG-16',
                'name' => 'Perdamaian, Keadilan, dan Kelembagaan yang Tangguh',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            46 => 
            array (
                'id' => 47,
                'parent_id' => NULL,
                'code' => 'SDG-17',
                'name' => 'Kemitraan untuk Mencapai Tujuan',
                'type' => 'SDGs',
                'period' => '2026',
                'created_at' => '2026-04-08 16:27:31',
                'updated_at' => '2026-04-08 16:27:31',
            ),
            47 => 
            array (
                'id' => 48,
                'parent_id' => NULL,
                'code' => 'IKU-TIK-1',
            'name' => 'Persentase ketersediaan layanan sistem informasi utama (SIAKAD, LMS, WEB)',
                'type' => 'IKU UNIT',
                'period' => '2026',
                'created_at' => '2026-04-22 23:05:46',
                'updated_at' => '2026-04-22 23:05:46',
            ),
            48 => 
            array (
                'id' => 49,
                'parent_id' => NULL,
                'code' => 'IKU-TIK-2',
            'name' => 'Indeks Kematangan Keamanan Siber (CSIRT)',
                'type' => 'IKU UNIT',
                'period' => '2026',
                'created_at' => '2026-04-22 23:05:46',
                'updated_at' => '2026-04-22 23:05:46',
            ),
            49 => 
            array (
                'id' => 50,
                'parent_id' => NULL,
                'code' => 'IKU-TIK-3',
                'name' => 'Indeks Kepuasan Pengguna terhadap Layanan TI',
                'type' => 'IKU UNIT',
                'period' => '2026',
                'created_at' => '2026-04-22 23:05:46',
                'updated_at' => '2026-04-22 23:05:46',
            ),
            50 => 
            array (
                'id' => 51,
                'parent_id' => NULL,
                'code' => 'IKU-GOV-1',
            'name' => 'Indeks Sistem Pemerintahan Berbasis Elektronik (SPBE)',
                'type' => 'IKU UNIT',
                'period' => '2026',
                'created_at' => '2026-04-22 23:05:46',
                'updated_at' => '2026-04-22 23:05:46',
            ),
            51 => 
            array (
                'id' => 52,
                'parent_id' => NULL,
                'code' => 'IKU-GOV-2',
            'name' => 'Nilai Reformasi Birokrasi (RB) Unit',
                'type' => 'IKU UNIT',
                'period' => '2026',
                'created_at' => '2026-04-22 23:05:46',
                'updated_at' => '2026-04-22 23:05:46',
            ),
        ));
        
        
    }
}