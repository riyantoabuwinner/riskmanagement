<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformanceIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── ASTA PROTAS ──
        $protas = [
            ['code' => 'PROTAS-1', 'name' => 'Meningkatkan Kerukunan dan Cinta Kemanusiaan', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-2', 'name' => 'Penguatan Ekoteologi', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-3', 'name' => 'Layanan Keagamaan Berdampak', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-4', 'name' => 'Pendidikan Unggul, Ramah & Terintegrasi', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-5', 'name' => 'Pemberdayaan Pesantren', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-6', 'name' => 'Pemberdayaan Ekonomi Umat', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-7', 'name' => 'Sukses Haji', 'type' => 'ASTA PROTAS'],
            ['code' => 'PROTAS-8', 'name' => 'Digitalisasi Tata Kelola', 'type' => 'ASTA PROTAS'],
        ];

        foreach ($protas as $item) {
            \App\Models\PerformanceIndicator::updateOrCreate(['code' => $item['code']], $item);
        }

        // ── IKU PTN ──
        $iku = [
            ['code' => 'IKU-1', 'name' => 'Lulusan mendapatkan pekerjaan yang layak', 'type' => 'IKU PTN'],
            ['code' => 'IKU-2', 'name' => 'Mahasiswa mendapat pengalaman di luar kampus', 'type' => 'IKU PTN'],
            ['code' => 'IKU-3', 'name' => 'Dosen berkegiatan di luar kampus', 'type' => 'IKU PTN'],
            ['code' => 'IKU-4', 'name' => 'Praktisi mengajar di dalam kampus', 'type' => 'IKU PTN'],
            ['code' => 'IKU-5', 'name' => 'Hasil kerja dosen digunakan oleh masyarakat', 'type' => 'IKU PTN'],
            ['code' => 'IKU-6', 'name' => 'Program studi bekerjasama dengan mitra kelas dunia', 'type' => 'IKU PTN'],
            ['code' => 'IKU-7', 'name' => 'Kelas yang kolaboratif dan partisipatif', 'type' => 'IKU PTN'],
            ['code' => 'IKU-8', 'name' => 'Program studi berstandar Internasional', 'type' => 'IKU PTN'],
        ];

        foreach ($iku as $item) {
            \App\Models\PerformanceIndicator::updateOrCreate(['code' => $item['code']], $item);
        }

        // ── PERKIN PENDIS ──
        $perkin = [
            ['code' => 'SP.7', 'name' => 'Meningkatnya Kualitas Standar dan Sistem Penjaminan Mutu', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.7.2', 'name' => 'Persentase PTK Islam yang terakreditasi', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.8', 'name' => 'Meningkatnya Dosen dan Tenaga Kependidikan yang Berkualitas', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.8.2', 'name' => 'Persentase dosen dan tenaga kependidikan PTK Islam yang memperoleh sertifikasi peningkatan kompetensi', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.9', 'name' => 'Meningkatnya Daya Saing Lulusan pada PTK', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.9.1', 'name' => 'Rata-rata masa tunggu lulusan PTK Islam untuk mendapatkan pekerjaan', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.10', 'name' => 'Meningkatnya Relevansi PTK melalui Penguatan Kemitraan Strategis', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.10.1', 'name' => 'Persentase kerja sama aktif yang menghasilkan program peningkatan mutu PTK Islam', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.11', 'name' => 'Meningkatnya Kualitas Karakter Keagamaan Mahasiswa yang ramah, Inklusif, dan Selaras dengan Nilai-nilai Kebangsaan', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.11.1', 'name' => 'Indeks Keberagamaan Mahasiswa Islam', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.12', 'name' => 'Meningkatnya Produktivitas dan Daya Saing Perguruan Tinggi Keagamaan', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.12.1', 'name' => 'Jumlah perguruan tinggi keagamaan Islam yang masuk ke dalam peringkat THE Impact SDGs', 'type' => 'PERKIN PENDIS']
            ]],
            ['code' => 'SP.13', 'name' => 'Meningkatnya Tata Kelola Organisasi yang Efektif dan Akuntabel', 'type' => 'PERKIN PENDIS', 'subs' => [
                ['code' => 'IKSP.13.2', 'name' => 'Nilai Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) UIN SSC', 'type' => 'PERKIN PENDIS']
            ]],
        ];

        foreach ($perkin as $item) {
            $subs = $item['subs'] ?? [];
            unset($item['subs']);
            $parent = \App\Models\PerformanceIndicator::updateOrCreate(['code' => $item['code']], $item);
            
            foreach ($subs as $sub) {
                $sub['parent_id'] = $parent->id;
                \App\Models\PerformanceIndicator::updateOrCreate(['code' => $sub['code']], $sub);
            }
        }

        // ── SDGs ──
        $sdgs = [
            ['code' => 'SDG-1', 'name' => 'Tanpa Kemiskinan', 'type' => 'SDGs'],
            ['code' => 'SDG-2', 'name' => 'Tanpa Kelaparan', 'type' => 'SDGs'],
            ['code' => 'SDG-3', 'name' => 'Kehidupan Sehat dan Sejahtera', 'type' => 'SDGs'],
            ['code' => 'SDG-4', 'name' => 'Pendidikan Berkualitas', 'type' => 'SDGs'],
            ['code' => 'SDG-5', 'name' => 'Kesetaraan Gender', 'type' => 'SDGs'],
            ['code' => 'SDG-6', 'name' => 'Air Bersih dan Sanitasi Layak', 'type' => 'SDGs'],
            ['code' => 'SDG-7', 'name' => 'Energi Bersih dan Terjangkau', 'type' => 'SDGs'],
            ['code' => 'SDG-8', 'name' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi', 'type' => 'SDGs'],
            ['code' => 'SDG-9', 'name' => 'Industri, Inovasi, dan Infrastruktur', 'type' => 'SDGs'],
            ['code' => 'SDG-10', 'name' => 'Berkurangnya Kesenjangan', 'type' => 'SDGs'],
            ['code' => 'SDG-11', 'name' => 'Kota dan Permukiman yang Berkelanjutan', 'type' => 'SDGs'],
            ['code' => 'SDG-12', 'name' => 'Konsumsi dan Produksi yang Bertanggung Jawab', 'type' => 'SDGs'],
            ['code' => 'SDG-13', 'name' => 'Penanganan Perubahan Iklim', 'type' => 'SDGs'],
            ['code' => 'SDG-14', 'name' => 'Ekosistem Lautan', 'type' => 'SDGs'],
            ['code' => 'SDG-15', 'name' => 'Ekosistem Daratan', 'type' => 'SDGs'],
            ['code' => 'SDG-16', 'name' => 'Perdamaian, Keadilan, dan Kelembagaan yang Tangguh', 'type' => 'SDGs'],
            ['code' => 'SDG-17', 'name' => 'Kemitraan untuk Mencapai Tujuan', 'type' => 'SDGs'],
        ];

        foreach ($sdgs as $item) {
            \App\Models\PerformanceIndicator::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
