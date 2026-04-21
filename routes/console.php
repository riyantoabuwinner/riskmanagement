<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('risks:check-deadlines')->dailyAt('08:00');

// Dynamic Backup Scheduling
try {
    $setting = \App\Models\BackupSetting::first();
    if ($setting && $setting->is_active) {
        $task = Schedule::command('app:backup-database');

        switch ($setting->frequency) {
            case 'daily':
                $task->dailyAt('00:00');
                break;
            case 'weekly':
                $task->weeklyOn(1, '00:00'); // Senin Jam 00:00
                break;
            case 'monthly':
                $task->monthlyOn(1, '00:00'); // Tanggal 1 Jam 00:00
                break;
        }
    }
} catch (\Exception $e) {
    // Silently fail if table doesn't exist yet (during migrations)
}
