<?php

use App\Models\User;
use App\Models\Unit;
use App\Models\Risk;
use App\Models\RiskCategory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Create or find a unit
$unit = Unit::firstOrCreate(['nama_unit' => 'Fakultas Test'], ['jenis_unit_id' => 1]);

// Create or find a category
$category = RiskCategory::firstOrCreate(['nama_kategori' => 'Operasional']);

// Create the Risk Officer user
$user = User::firstOrCreate(
['email' => 'officer@test.com'],
[
    'name' => 'Test Risk Officer',
    'password' => Hash::make('password'),
    'unit_id' => $unit->id
]
);

// Assign role
$role = Role::where('name', 'Risk Officer')->first();
if ($role && !$user->hasRole('Risk Officer')) {
    $user->assignRole($role);
}

// Create a Submitted Risk for this unit
$risk = Risk::create([
    'nama_risiko' => 'Risiko Test Evaluasi Mendalam',
    'deskripsi' => 'Ini adalah risiko untuk diuji oleh browser subagent.',
    'kategori_id' => $category->id,
    'unit_id' => $unit->id,
    'probabilitas' => 3,
    'level_dampak' => 4,
    'skor_risiko' => 12,
    'level_risiko' => 'High',
    'status' => 'Submitted',
    'created_by' => $user->id,
    'tanggal_identifikasi' => now()
]);

echo "Test data seeded successfully. User: officer@test.com / password\n";
