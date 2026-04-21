<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackupSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BackupSetting::firstOrCreate(
        ['id' => 1],
        [
            'frequency' => 'daily',
            'is_active' => false,
            'last_run_at' => null,
        ]
        );
    }
}
