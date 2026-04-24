<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SystemUpdateController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        // Perform a quick fetch to ensure origin/main is up to date before checking
        @shell_exec('git fetch origin main');

        $status = $this->getGitStatus();
        $log = $this->getGitLog();
        $lastOutput = session('update_output', 'Belum ada output eksekusi terbaru.');
        
        // Check if updates are available
        $localHash = trim(@shell_exec('git rev-parse HEAD'));
        $remoteHash = trim(@shell_exec('git rev-parse origin/main'));
        $hasUpdates = !empty($remoteHash) && $localHash !== $remoteHash;

        // Check for local changes
        $isDirty = !empty(trim(@shell_exec('git status --short')));

        return view('system_update.index', compact('status', 'log', 'lastOutput', 'hasUpdates', 'isDirty', 'localHash', 'remoteHash'));
    }

    public function check()
    {
        $this->authorizeAdmin();

        try {
            $output = [];
            $returnVar = 0;
            exec('git fetch origin main 2>&1', $output, $returnVar);
            
            if ($returnVar === 0) {
                return back()->with('success', 'Berhasil mengecek pembaruan. Halaman telah diperbarui dengan data terbaru dari GitHub.');
            } else {
                return back()->with('error', 'Gagal mengecek pembaruan: ' . implode("\n", $output));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->authorizeAdmin();

        try {
            // Re-check updates before proceeding
            $localHash = trim(@shell_exec('git rev-parse HEAD'));
            $remoteHash = trim(@shell_exec('git rev-parse origin/main'));

            if (empty($remoteHash)) {
                return back()->with('error', 'Gagal mengambil data dari remote repository. Pastikan koneksi internet tersedia.');
            }

            if ($localHash === $remoteHash) {
                return back()->with('info', 'Sistem sudah dalam versi terbaru. Tidak ada yang perlu diperbarui.');
            }

            $output = [];
            
            // Execute Git Pull
            $output[] = "[" . now()->format('H:i:s') . "] --- MEMULAI GIT PULL ---";
            $pullOutput = [];
            $pullReturn = 0;
            exec('git pull origin main 2>&1', $pullOutput, $pullReturn);
            $output = array_merge($output, $pullOutput);

            if ($pullReturn !== 0) {
                $fullOutput = implode("\n", $output);
                return redirect()->route('system-update.index')
                    ->with('update_output', $fullOutput)
                    ->with('error', 'Gagal melakukan pembaruan (Git Pull Error). Cek konsol output untuk detail.');
            }

            // Clear Cache & Optimize
            $output[] = "\n[" . now()->format('H:i:s') . "] --- MEMBERSIHKAN CACHE & OPTIMASI ---";
            try {
                Artisan::call('optimize:clear');
                $output[] = Artisan::output();
                
                // Optional: Run migrations if needed
                // Artisan::call('migrate', ['--force' => true]);
                // $output[] = Artisan::output();
            } catch (\Exception $ae) {
                $output[] = "Error Artisan: " . $ae->getMessage();
            }

            $fullOutput = implode("\n", $output);
            
            return redirect()->route('system-update.index')
                ->with('update_output', $fullOutput)
                ->with('success', 'Sistem berhasil diperbarui ke versi terbaru!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan fatal saat pembaruan: ' . $e->getMessage());
        }
    }

    private function getGitStatus()
    {
        try {
            $branch = trim(@shell_exec('git rev-parse --abbrev-ref HEAD'));
            $hash = trim(@shell_exec('git rev-parse --short HEAD'));
            $date = trim(@shell_exec('git log -1 --format=%cd --date=relative'));

            return [
                'branch' => $branch ?: 'Unknown',
                'hash' => $hash ?: 'Unknown',
                'date' => $date ?: 'Unknown',
            ];
        } catch (\Exception $e) {
            return [
                'branch' => 'Error',
                'hash' => 'Error',
                'date' => 'Error',
            ];
        }
    }

    private function getGitLog()
    {
        try {
            // Get last 10 commits
            $log = @shell_exec('git log -10 --pretty=format:"%h %s (%cr) <%an>" --abbrev-commit');
            return $log ?: 'Tidak ada riwayat perubahan yang ditemukan.';
        } catch (\Exception $e) {
            return 'Gagal mengambil riwayat perubahan.';
        }
    }

    private function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }
    }
}

