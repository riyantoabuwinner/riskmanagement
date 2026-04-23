<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;
use App\Models\Unit;
use App\Models\User;
use App\Models\Mitigation;
use App\Models\RiskCategory;
use App\Models\PerformanceIndicator;
use Carbon\Carbon;

class ExampleRiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan Unit Kerja UPT TIK
        $unit = Unit::where('nama_unit', 'LIKE', '%Teknologi Informasi%')->first();
        if (!$unit) {
            $unit = Unit::create([
                'nama_unit' => 'UPT Teknologi Informasi dan Komunikasi',
                'kode_unit' => 'UPT-TIK',
                'pimpinan' => 'Kepala UPT TIK'
            ]);
        }

        // 2. Dapatkan User berdasarkan role (sesuai UserSeeder)
        $owner = User::role('Risk Owner')->where('unit_id', $unit->id)->first();
        $officer = User::role('Risk Officer')->where('unit_id', $unit->id)->first();
        $manager = User::role('Risk Manager')->where('unit_id', $unit->id)->first();
        
        // Jika user tidak ditemukan (mungkin seeder sebelumnya belum jalan), buat manual
        if (!$owner) {
            $owner = User::create([
                'name' => 'Owner TIK', 'email' => 'owner_tik@uinssc.ac.id', 
                'password' => bcrypt('silenthustle'), 'unit_id' => $unit->id
            ]);
            $owner->assignRole('Risk Owner');
        }

        // 3. Ambil Indikator Kinerja (IKU) yang relevan
        $iku = PerformanceIndicator::where('code', 'IKU-TIK-1')->first(); // Ketersediaan Layanan Utama
        
        // 4. Ambil Kategori Risiko
        $kategori = RiskCategory::where('kode', 'ICT')->first() ?? RiskCategory::first();

        // 5. PROSES: Identifikasi Risiko (oleh Risk Owner)
        $risk = Risk::updateOrCreate(
            ['nama_risiko' => 'Kegagalan Sistem Informasi Akademik (SIAKAD) pada Masa KRS'],
            [
                'unit_id' => $unit->id,
                'kategori_id' => $kategori->id,
                'kode_risiko' => 'ICT-001',
                'nomor_urut' => 1,
                'sasaran_strategis' => $iku ? "[$iku->code] $iku->name" : 'Digitalisasi Layanan Akademik',
                'deskripsi' => 'Server tidak mampu menangani lonjakan traffic saat periode pengisian KRS serentak.',
                'penyebab' => 'Kapasitas RAM dan CPU server terbatas, serta belum adanya load balancing.',
                'dampak' => 'Mahasiswa tidak bisa mengisi KRS, jadwal akademik terganggu, dan keluhan publik meningkat.',
                'status' => 'Review', // Sudah diajukan ke Officer
                'tanggal_identifikasi' => Carbon::now(),
                'created_by' => $owner->id
            ]
        );

        // 6. PROSES: Analisis & Evaluasi (oleh Risk Officer)
        // Officer menentukan Probabilitas (1-5) dan Dampak (1-5)
        $probabilitas = 4; // Sering Terjadi
        $dampakLevel = 5; // Sangat Besar
        $skor = $probabilitas * $dampakLevel; // 20 (Extreme)
        
        $risk->update([
            'probabilitas' => $probabilitas,
            'level_dampak' => $dampakLevel,
            'skor_risiko' => $skor,
            'level_risiko' => 'Extreme',
            'catatan_evaluasi' => 'Risiko ini sangat kritis karena berdampak langsung pada layanan utama universitas.',
            'status' => 'Approved' // Diasumsikan sudah disetujui Manager setelah evaluasi
        ]);

        // 7. PROSES: Perencanaan Mitigasi (oleh Risk Owner/Officer)
        Mitigation::updateOrCreate(
            ['risk_id' => $risk->id, 'strategi' => 'Upgrade Infrastruktur Cloud & Implementasi Load Balancing'],
            [
                'rencana_aksi' => 'Melakukan upgrade kapasitas server sementara selama masa KRS dan memasang sistem load balancing untuk membagi traffic.',
                'anggaran' => 25000000,
                'penanggung_jawab' => 'Koordinator Infrastruktur TI',
                'target_waktu' => Carbon::now()->addMonths(2),
                'status' => 'On Progress'
            ]
        );

        Mitigation::updateOrCreate(
            ['risk_id' => $risk->id, 'strategi' => 'Penjadwalan KRS Berbasis Angkatan'],
            [
                'rencana_aksi' => 'Membagi jadwal akses login SIAKAD berdasarkan angkatan untuk mengurangi beban traffic simultan.',
                'anggaran' => 0,
                'penanggung_jawab' => 'Bagian Akademik & TIK',
                'target_waktu' => Carbon::now()->addDays(14),
                'status' => 'Completed'
            ]
        );

        // 8. PROSES: Monitoring & Analisis Risiko Residual (oleh Risk Officer/Manager)
        \App\Models\RiskMonitoring::updateOrCreate(
            ['risk_id' => $risk->id],
            [
                'progress' => 75,
                'catatan' => 'Setelah implementasi penjadwalan angkatan, beban server berkurang signifikan. Namun upgrade infrastruktur masih dalam tahap pengadaan.',
                'tanggal_update' => Carbon::now(),
                'residual_probabilitas' => 2, // Turun dari 4
                'residual_impact' => 3,       // Turun dari 5
                'residual_score' => 6,        // 2x3 = 6
                'residual_level' => 'Medium'  // Turun dari Extreme
            ]
        );
    }
}
