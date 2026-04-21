<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database MySQL menggunakan mysqldump';

    public function handle()
    {
        $this->info('Memulai proses backup database...');

        $date = now()->format('Y-m-d_H-i-s');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $sqlFile = "{$backupDir}/backup_{$dbName}_{$date}.sql";
        $zipFile = "{$backupDir}/backup_{$dbName}_{$date}.zip";

        // Path ke mysqldump di XAMPP Windows
        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';

        $command = sprintf(
            '"%s" --user=%s %s --host=%s %s > "%s"',
            $mysqldumpPath,
            $dbUser,
            ($dbPass ? "--password={$dbPass}" : ''),
            $dbHost,
            $dbName,
            $sqlFile
        );

        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $error = "Gagal melakukan dump database. Return code: {$returnVar}";
            $this->error($error);
            \App\Models\BackupLog::create([
                'filename' => "backup_{$dbName}_{$date}.sql",
                'size' => '0',
                'status' => 'failed',
                'error_message' => $error,
            ]);
            return 1;
        }

        // Zip the file
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, \ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, basename($sqlFile));
            $zip->close();
            unlink($sqlFile); // Hapus file SQL setelah di-zip
        }
        else {
            $error = "Gagal membuat file zip.";
            $this->error($error);
            return 1;
        }

        $size = filesize($zipFile);
        $sizeFormatted = round($size / 1024 / 1024, 2) . ' MB';

        \App\Models\BackupLog::create([
            'filename' => basename($zipFile),
            'size' => $sizeFormatted,
            'status' => 'success',
        ]);

        \App\Models\BackupSetting::first()->update(['last_run_at' => now()]);

        $this->info("Backup berhasil: " . basename($zipFile));

        // Pruning: Hapus backup lama (sisakan 10 terakhir)
        $files = glob("{$backupDir}/*.zip");
        if (count($files) > 10) {
            array_multisort(array_map('filemtime', $files), SORT_ASC, $files);
            while (count($files) > 10) {
                $fileToDelete = array_shift($files);
                unlink($fileToDelete);
                $this->line("Menghapus backup lama: " . basename($fileToDelete));
            }
        }

        return 0;
    }
}
