<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('units')->delete();
        
        \DB::table('units')->insert(array (
            0 => 
            array (
                'id' => 9,
                'kode' => 'BA-BDJ',
                'nama_unit' => 'Biro AKU - Barang dan Jasa',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            1 => 
            array (
                'id' => 10,
                'kode' => 'BA-P',
                'nama_unit' => 'Biro AKU - Perencanaan',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            2 => 
            array (
                'id' => 11,
                'kode' => 'BA-K',
                'nama_unit' => 'Biro AKU - Keuangan',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            3 => 
            array (
                'id' => 12,
                'kode' => 'BA-K1',
                'nama_unit' => 'Biro AKU - Kepegawaian',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            4 => 
            array (
                'id' => 13,
                'kode' => 'BA-H',
                'nama_unit' => 'Biro AKU - Humas',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            5 => 
            array (
                'id' => 14,
                'kode' => 'BA-A',
                'nama_unit' => 'Biro AKU - Arsiparis',
                'unit_type_id' => 4,
                'pimpinan' => 'Kepala Biro',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            6 => 
            array (
                'id' => 15,
                'kode' => 'LPM',
                'nama_unit' => 'Lembaga Penjaminan Mutu',
                'unit_type_id' => 2,
                'pimpinan' => 'Ketua Lembaga',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            7 => 
            array (
                'id' => 16,
                'kode' => 'PADPM',
                'nama_unit' => 'Pusat Audit dan Pengendalian Mutu',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            8 => 
            array (
                'id' => 17,
                'kode' => 'PPSMD',
                'nama_unit' => 'Pusat Pengembangan Standar Mutu Digital',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            9 => 
            array (
                'id' => 18,
                'kode' => 'LPDPM',
                'nama_unit' => 'Lembaga Penelitian dan Pengabdian Masyarakat',
                'unit_type_id' => 2,
                'pimpinan' => 'Ketua Lembaga',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            10 => 
            array (
                'id' => 19,
                'kode' => 'PPPI',
                'nama_unit' => 'Pusat Penelitian Pengembangan Industri',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            11 => 
            array (
                'id' => 20,
                'kode' => 'PPKMDS',
                'nama_unit' => 'Pusat Pengabdian kepada Masyarakat dan SDG’s',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            12 => 
            array (
                'id' => 21,
                'kode' => 'PSGHADD',
                'nama_unit' => 'Pusat Studi Gender, Hak Anak dan Difabel',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            13 => 
            array (
                'id' => 22,
                'kode' => 'PPIDP',
                'nama_unit' => 'Pusat Publikasi Ilmiah dan Pemeringkatan',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            14 => 
            array (
                'id' => 23,
                'kode' => 'SPI',
                'nama_unit' => 'Satuan Pengawas Internal',
                'unit_type_id' => 2,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            15 => 
            array (
                'id' => 24,
                'kode' => 'UMAJ',
                'nama_unit' => 'UPT Mahad Al Jami\'ah',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            16 => 
            array (
                'id' => 25,
                'kode' => 'UP',
                'nama_unit' => 'UPT Perpustakaan',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            17 => 
            array (
                'id' => 26,
                'kode' => 'UPB',
                'nama_unit' => 'UPT Pusat Bahasa',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            18 => 
            array (
                'id' => 27,
                'kode' => 'UTIDK',
                'nama_unit' => 'UPT Teknologi Informasi dan Komunikasi',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            19 => 
            array (
                'id' => 28,
                'kode' => 'UK',
                'nama_unit' => 'UPT Karir',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            20 => 
            array (
                'id' => 29,
                'kode' => 'UPJJ',
                'nama_unit' => 'UPT Pendidikan Jarak Jauh',
                'unit_type_id' => 3,
                'pimpinan' => 'Kepala UPT',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            21 => 
            array (
                'id' => 30,
                'kode' => 'PIDPD',
                'nama_unit' => 'Pusat Inovasi dan Pembelajaran Digital',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            22 => 
            array (
                'id' => 31,
                'kode' => 'PLT',
                'nama_unit' => 'Pusat Layanan Terpadu',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            23 => 
            array (
                'id' => 32,
                'kode' => 'PKDBH',
                'nama_unit' => 'Pusat Konsultasi dan Bantuan Humum',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            24 => 
            array (
                'id' => 33,
                'kode' => 'PPB',
                'nama_unit' => 'Pusat Pengembangan Bisnis',
                'unit_type_id' => 5,
                'pimpinan' => 'Kepala Pusat',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            25 => 
            array (
                'id' => 34,
                'kode' => 'FITDK',
                'nama_unit' => 'Fakultas Ilmu Tarbiyah dan Keguruan',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            26 => 
            array (
                'id' => 35,
                'kode' => 'FUDA',
                'nama_unit' => 'Fakultas Ushuluddin dan Adab',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            27 => 
            array (
                'id' => 36,
                'kode' => 'FS',
                'nama_unit' => 'Fakultas Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            28 => 
            array (
                'id' => 37,
                'kode' => 'FEDBI',
                'nama_unit' => 'Fakultas Ekonomi dan Bisnis Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            29 => 
            array (
                'id' => 38,
                'kode' => 'FDDKI',
                'nama_unit' => 'Fakultas Dakwah dan Komunikasi Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            30 => 
            array (
                'id' => 39,
                'kode' => 'P',
                'nama_unit' => 'Pascasarjana',
                'unit_type_id' => 1,
                'pimpinan' => 'Dekan',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            31 => 
            array (
                'id' => 40,
                'kode' => 'PSAFI',
                'nama_unit' => 'Program Studi Akidah Filsafat Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            32 => 
            array (
                'id' => 41,
                'kode' => 'PSAS',
                'nama_unit' => 'Program Studi Akuntansi Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            33 => 
            array (
                'id' => 42,
                'kode' => 'PSAS1',
                'nama_unit' => 'Program Studi Akhwalul Syakhsiyah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            34 => 
            array (
                'id' => 43,
                'kode' => 'PSB',
                'nama_unit' => 'Program Studi Bioteknologi',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            35 => 
            array (
                'id' => 44,
                'kode' => 'PSBDKI',
                'nama_unit' => 'Program Studi Bimbingan dan Konseling Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            36 => 
            array (
                'id' => 45,
                'kode' => 'PSBDSA',
                'nama_unit' => 'Program Studi Bahasa dan Sastra Arab',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            37 => 
            array (
                'id' => 46,
                'kode' => 'PSES',
                'nama_unit' => 'Program Studi Ekonomi Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            38 => 
            array (
                'id' => 47,
                'kode' => 'PSHTNI',
                'nama_unit' => 'Program Studi Hulum Tata Negara Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            39 => 
            array (
                'id' => 48,
                'kode' => 'PSIAQDT',
                'nama_unit' => 'Program Studi Ilmu Al Qur\'an dan Tafsir',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            40 => 
            array (
                'id' => 49,
                'kode' => 'PSIH',
                'nama_unit' => 'Program Studi Ilmu Hadis',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            41 => 
            array (
                'id' => 50,
                'kode' => 'PSIF',
                'nama_unit' => 'Program Studi Ilmu Falak',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            42 => 
            array (
                'id' => 51,
                'kode' => 'PSI',
                'nama_unit' => 'Program Studi Informatika',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            43 => 
            array (
                'id' => 52,
                'kode' => 'PSKDPI',
                'nama_unit' => 'Program Studi Komunikasi dan Penyiaran Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            44 => 
            array (
                'id' => 53,
                'kode' => 'PSHES',
                'nama_unit' => 'Program Studi Hukum Ekonomi Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            45 => 
            array (
                'id' => 54,
                'kode' => 'PSM',
                'nama_unit' => 'Program Studi Matematika',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            46 => 
            array (
                'id' => 55,
                'kode' => 'PSMPI',
                'nama_unit' => 'Program Studi Manajemen Pendidikan Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            47 => 
            array (
                'id' => 56,
                'kode' => 'PSPAI',
                'nama_unit' => 'Program Studi Pendidikan Agama Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            48 => 
            array (
                'id' => 57,
                'kode' => 'PSPS',
                'nama_unit' => 'Program Studi Pariwisata Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            49 => 
            array (
                'id' => 58,
                'kode' => 'PSPBA',
                'nama_unit' => 'Program Studi Pendidikan Bahasa Arab',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            50 => 
            array (
                'id' => 59,
                'kode' => 'PSPGMI',
                'nama_unit' => 'Program Studi Pendidikan Guru Madrasah Ibtidaiyah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            51 => 
            array (
                'id' => 60,
                'kode' => 'PSPIAUD',
                'nama_unit' => 'Program Studi Pendidikan Islam Anak Usia Dini',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            52 => 
            array (
                'id' => 61,
                'kode' => 'PSPPGMI',
                'nama_unit' => 'Program Studi PJJ Pendidikan Guru Madrasah Ibtidaiyah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            53 => 
            array (
                'id' => 62,
                'kode' => 'PSPMI',
                'nama_unit' => 'Program Studi Pengembangan Masyarakat Islam',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            54 => 
            array (
                'id' => 63,
                'kode' => 'PSPS1',
                'nama_unit' => 'Program Studi Perbankan Syariah',
                'unit_type_id' => 1,
                'pimpinan' => 'Ketua Program Studi',
                'created_at' => '2026-04-22 22:32:00',
                'updated_at' => '2026-04-22 22:32:00',
            ),
            55 => 
            array (
                'id' => 64,
                'kode' => 'PSES(',
                'nama_unit' => 'Program Studi Ekonomi Syariah (S2)',
                    'unit_type_id' => 1,
                    'pimpinan' => 'Ketua Program Studi',
                    'created_at' => '2026-04-22 22:32:00',
                    'updated_at' => '2026-04-22 22:32:00',
                ),
                56 => 
                array (
                    'id' => 65,
                    'kode' => 'PSHK(S(',
                    'nama_unit' => 'Program Studi Hukum Keluarga (Akhwalul Syaksiyah) (S2)',
                        'unit_type_id' => 1,
                        'pimpinan' => 'Ketua Program Studi',
                        'created_at' => '2026-04-22 22:32:01',
                        'updated_at' => '2026-04-22 22:32:01',
                    ),
                    57 => 
                    array (
                        'id' => 66,
                        'kode' => 'PSMPI(',
                        'nama_unit' => 'Program Studi Manajemen Pendidikan Islam (S2)',
                            'unit_type_id' => 1,
                            'pimpinan' => 'Ketua Program Studi',
                            'created_at' => '2026-04-22 22:32:01',
                            'updated_at' => '2026-04-22 22:32:01',
                        ),
                        58 => 
                        array (
                            'id' => 67,
                            'kode' => 'PSPAI(',
                            'nama_unit' => 'Program Studi Pendidikan Agama Islam (S2)',
                                'unit_type_id' => 1,
                                'pimpinan' => 'Ketua Program Studi',
                                'created_at' => '2026-04-22 22:32:01',
                                'updated_at' => '2026-04-22 22:32:01',
                            ),
                            59 => 
                            array (
                                'id' => 68,
                                'kode' => 'PSPMI(',
                                'nama_unit' => 'Program Studi Pengembangan Masyarakat Islam (S2)',
                                    'unit_type_id' => 1,
                                    'pimpinan' => 'Ketua Program Studi',
                                    'created_at' => '2026-04-22 22:32:01',
                                    'updated_at' => '2026-04-22 22:32:01',
                                ),
                                60 => 
                                array (
                                    'id' => 69,
                                    'kode' => 'PSSPI(',
                                    'nama_unit' => 'Program Studi Sejarah Peradaban Islam (S2)',
                                        'unit_type_id' => 1,
                                        'pimpinan' => 'Ketua Program Studi',
                                        'created_at' => '2026-04-22 22:32:01',
                                        'updated_at' => '2026-04-22 22:32:01',
                                    ),
                                    61 => 
                                    array (
                                        'id' => 70,
                                        'kode' => 'PSES(1',
                                        'nama_unit' => 'Program Studi Ekonomi Syariah (S3)',
                                            'unit_type_id' => 1,
                                            'pimpinan' => 'Ketua Program Studi',
                                            'created_at' => '2026-04-22 22:32:01',
                                            'updated_at' => '2026-04-22 22:32:01',
                                        ),
                                        62 => 
                                        array (
                                            'id' => 71,
                                            'kode' => 'PSHKI(S(',
                                            'nama_unit' => 'Program Studi Hukum Keluarga Islam (Ahwal Syakhshiyyah) (S3)',
                                                'unit_type_id' => 1,
                                                'pimpinan' => 'Ketua Program Studi',
                                                'created_at' => '2026-04-22 22:32:01',
                                                'updated_at' => '2026-04-22 22:32:01',
                                            ),
                                            63 => 
                                            array (
                                                'id' => 72,
                                                'kode' => 'PSPAI(1',
                                                'nama_unit' => 'Program Studi Pendidikan Agama Islam (S3)',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                64 => 
                                                array (
                                                    'id' => 73,
                                                    'kode' => 'PSSA',
                                                    'nama_unit' => 'Program Studi Sosiologi Agama',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                65 => 
                                                array (
                                                    'id' => 74,
                                                    'kode' => 'PSSPI',
                                                    'nama_unit' => 'Program Studi Sejarah Peradaban Islam',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                66 => 
                                                array (
                                                    'id' => 75,
                                                    'kode' => 'PSTDP',
                                                    'nama_unit' => 'Program Studi Tasawuf dan Psikoterapi',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                67 => 
                                                array (
                                                    'id' => 76,
                                                    'kode' => 'PSTBI',
                                                    'nama_unit' => 'Program Studi Tadris Bahasa Inggris',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                68 => 
                                                array (
                                                    'id' => 77,
                                                    'kode' => 'PSTBI1',
                                                    'nama_unit' => 'Program Studi Tadris Bahasa Indonesia',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                69 => 
                                                array (
                                                    'id' => 78,
                                                    'kode' => 'PSTB',
                                                    'nama_unit' => 'Program Studi Tadris Biologi',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                70 => 
                                                array (
                                                    'id' => 79,
                                                    'kode' => 'PSTI',
                                                    'nama_unit' => 'Program Studi Tadris IPS',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                                71 => 
                                                array (
                                                    'id' => 80,
                                                    'kode' => 'PSTK',
                                                    'nama_unit' => 'Program Studi Tadris Kimia',
                                                    'unit_type_id' => 1,
                                                    'pimpinan' => 'Ketua Program Studi',
                                                    'created_at' => '2026-04-22 22:32:01',
                                                    'updated_at' => '2026-04-22 22:32:01',
                                                ),
                                            ));
        
        
    }
}