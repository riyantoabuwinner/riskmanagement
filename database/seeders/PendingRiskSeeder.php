<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;
use App\Models\Unit;
use App\Models\User;
use App\Models\RiskCategory;
use App\Models\PerformanceIndicator;
use Carbon\Carbon;

class PendingRiskSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('nama_unit', 'LIKE', '%Teknologi Informasi%')->first();
        $owner = User::role('Risk Owner')->where('unit_id', $unit->id)->first();
        $kategori = RiskCategory::where('kode', 'ICT')->first() ?? RiskCategory::first();
        $iku = PerformanceIndicator::where('code', 'IKU-TIK-2')->first(); // Keamanan Siber

        // Buat risiko yang sedang menunggu analisis (Status: Submitted)
        Risk::updateOrCreate(
            ['nama_risiko' => 'Potensi Serangan Ransomware pada Database Kepegawaian'],
            [
                'unit_id' => $unit->id,
                'kategori_id' => $kategori->id,
                'kode_risiko' => 'ICT-002',
                'nomor_urut' => 2,
                'sasaran_strategis' => $iku ? "[$iku->code] $iku->name" : 'Keamanan Data Institusi',
                'deskripsi' => 'Ditemukan celah keamanan pada sistem operasi server database yang belum di-patch.',
                'penyebab' => 'Kurangnya jadwal maintenance rutin dan keterbatasan personil IT security.',
                'dampak' => 'Seluruh data kepegawaian terkunci, layanan administrasi lumpuh total.',
                'status' => 'Submitted', // Penting: Status ini agar muncul di halaman Analisis
                'tanggal_identifikasi' => Carbon::now(),
                'created_by' => $owner->id,
                // Nilai analisis dikosongkan dulu atau diset default rendah agar Officer yang menentukan
                'probabilitas' => 1,
                'level_dampak' => 1,
                'skor_risiko' => 1,
                'level_risiko' => 'Low'
            ]
        );
    }
}
