<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;
use App\Models\PerformanceIndicator;

class MultipleIndicatorDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari risiko SIAKAD yang dibuat oleh ExampleRiskSeeder
        $risk = Risk::where('nama_risiko', 'LIKE', '%SIAKAD%')->first();

        if ($risk) {
            // 2. Ambil beberapa indikator dari framework yang berbeda
            $indicators = PerformanceIndicator::whereIn('code', [
                'IKU-TIK-1', // IKU UNIT (Existing in ExampleRiskSeeder)
                'PROTAS-8',  // ASTA PROTAS (Digitalisasi)
                'SDG-4',     // SDGs (Pendidikan Berkualitas)
                'IKSP.13.2'  // PERKIN PENDIS (SAKIP/Tata Kelola)
            ])->pluck('id');

            // 3. Hubungkan ke risiko menggunakan pivot table
            $risk->performanceIndicators()->sync($indicators);

            $this->command->info("Berhasil mengaitkan risiko '{$risk->nama_risiko}' dengan " . count($indicators) . " Indikator Kinerja lintas framework.");
        } else {
            $this->command->error("Risiko contoh SIAKAD tidak ditemukan. Pastikan ExampleRiskSeeder sudah dijalankan.");
        }

        // 4. Tambahkan contoh kedua untuk risiko lain jika ada
        $anotherRisk = Risk::where('nama_risiko', 'NOT LIKE', '%SIAKAD%')->first();
        if ($anotherRisk) {
            $moreIndicators = PerformanceIndicator::whereIn('code', [
                'IKU-1',    // IKU PTN (Lulusan)
                'SDG-8',    // SDGs (Pekerjaan Layak)
                'IKSP.9.1'  // PERKIN PENDIS (Masa Tunggu)
            ])->pluck('id');

            $anotherRisk->performanceIndicators()->sync($moreIndicators);
            $this->command->info("Berhasil mengaitkan risiko '{$anotherRisk->nama_risiko}' dengan " . count($moreIndicators) . " Indikator Kinerja.");
        }
    }
}
