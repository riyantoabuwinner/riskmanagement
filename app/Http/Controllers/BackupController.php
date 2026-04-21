<?php

namespace App\Http\Controllers;

use App\Models\BackupSetting;
use App\Models\BackupLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $setting = BackupSetting::first();
        $logs = BackupLog::latest()->take(20)->get();
        $backupFiles = glob(storage_path('app/backups/*.zip'));

        $backups = [];
        foreach ($backupFiles as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => round(filesize($file) / 1024 / 1024, 2) . ' MB',
                'created_at' => filemtime($file),
            ];
        }

        // Sort by created_at desc
        usort($backups, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return view('backups.index', compact('setting', 'logs', 'backups'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'is_active' => 'boolean',
        ]);

        $setting = BackupSetting::first();
        $setting->update([
            'frequency' => $request->frequency,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Pengaturan backup berhasil diperbarui.');
    }

    public function run()
    {
        try {
            Artisan::call('app:backup-database');
            return redirect()->back()->with('success', 'Proses backup manual berhasil dijalankan.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menjalankan backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    public function destroy($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
}
