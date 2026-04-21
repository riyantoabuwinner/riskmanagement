<?php

namespace Database\Seeders;

use App\Models\Risk;
use App\Models\AuditLog;
use App\Models\RiskCategory;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoRiskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@uinsc.ac.id')->first();
        if (!$admin)
            return;

        $cat = RiskCategory::first();
        $unit = Unit::first();

        $risks = [
            [
                'nama_risiko' => 'Risiko Keamanan Siber (Demo)',
                'deskripsi' => 'Potensi serangan ransomware pada server database utama.',
                'kategori_id' => $cat->id,
                'unit_id' => $unit->id,
                'penyebab' => 'Sistem operasi belum terupdate.',
                'dampak' => 'Kehilangan data transaksi dan reputasi.',
                'probabilitas' => 4,
                'level_dampak' => 5,
                'skor_risiko' => 20,
                'level_risiko' => 'Extreme',
                'status' => 'Approved',
                'created_by' => $admin->id,
            ],
            [
                'nama_risiko' => 'Keterlambatan Pelaporan Keuangan (Demo)',
                'deskripsi' => 'Pengiriman laporan BLU melewati tenggat waktu.',
                'kategori_id' => $cat->id,
                'unit_id' => $unit->id,
                'penyebab' => 'Kurangnya staf accounting.',
                'dampak' => 'Sanksi administrasi dari Kemenkeu.',
                'probabilitas' => 3,
                'level_dampak' => 3,
                'skor_risiko' => 9,
                'level_risiko' => 'High',
                'status' => 'Submitted',
                'created_by' => $admin->id,
            ],
            [
                'nama_risiko' => 'Penurunan Akreditasi Program Studi (Demo)',
                'deskripsi' => 'Nilai akreditasi turun dari Unggul ke Baik Sekali.',
                'kategori_id' => $cat->id,
                'unit_id' => $unit->id,
                'penyebab' => 'Kurangnya publikasi internasional dosen.',
                'dampak' => 'Penurunan minat mahasiswa baru.',
                'probabilitas' => 2,
                'level_dampak' => 4,
                'skor_risiko' => 8,
                'level_risiko' => 'High',
                'status' => 'Reviewed',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($risks as $data) {
            $risk = Risk::create($data);

            AuditLog::create([
                'user_id' => $admin->id,
                'risk_id' => $risk->id,
                'aktivitas' => 'Identifikasi risiko awal (Seeding)',
                'ip_address' => '127.0.0.1',
                'waktu' => now(),
            ]);

            if ($risk->status !== 'Draft') {
                AuditLog::create([
                    'user_id' => $admin->id,
                    'risk_id' => $risk->id,
                    'aktivitas' => 'Transisi status ke ' . $risk->status . ' (Seeding)',
                    'ip_address' => '127.0.0.1',
                    'waktu' => now()->addMinutes(5),
                ]);
            }
        }
    }
}
