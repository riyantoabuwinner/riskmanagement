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

        $status = $this->getGitStatus();
        $log = $this->getGitLog();
        $lastOutput = session('update_output', 'Belum ada output eksekusi terbaru.');
        
        // Check if updates are available
        $localHash = shell_exec('git rev-parse HEAD');
        $remoteHash = shell_exec('git rev-parse origin/main');
        $hasUpdates = trim($localHash) !== trim($remoteHash);

        return view('system_update.index', compact('status', 'log', 'lastOutput', 'hasUpdates'));
    }

    public function check()
    {
        $this->authorizeAdmin();

        try {
            shell_exec('git fetch origin');
            return back()->with('success', 'Berhasil mengecek pembaruan. Halaman telah diperbarui dengan data terbaru.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengecek pembaruan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->authorizeAdmin();

        try {
            // Re-check updates before proceeding
            $localHash = trim(shell_exec('git rev-parse HEAD'));
            $remoteHash = trim(shell_exec('git rev-parse origin/main'));

            if ($localHash === $remoteHash) {
                return back()->with('info', 'Sistem sudah dalam versi terbaru. Tidak ada yang perlu diperbarui.');
            }

            $output = [];
            
            // Execute Git Pull
            $output[] = "[" . now()->format('H:i:s') . "] --- MEMULAI GIT PULL ---";
            $gitPull = shell_exec('git pull origin main 2>&1');
            $output[] = $gitPull;

            // Clear Cache
            $output[] = "\n[" . now()->format('H:i:s') . "] --- MEMBERSIHKAN CACHE & OPTIMASI ---";
            Artisan::call('optimize:clear');
            $output[] = Artisan::output();

            $fullOutput = implode("\n", $output);
            
            return redirect()->route('system-update.index')
                ->with('update_output', $fullOutput)
                ->with('success', 'Sistem berhasil diperbarui ke versi terbaru!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat pembaruan: ' . $e->getMessage());
        }
    }

    private function getGitStatus()
    {
        try {
            $branch = trim(shell_exec('git rev-parse --abbrev-ref HEAD'));
            $hash = trim(shell_exec('git rev-parse --short HEAD'));
            $date = trim(shell_exec('git log -1 --format=%cd --date=relative'));

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
            return shell_exec('git log -10 --pretty=format:"%h %s (%cr) <%an>" --abbrev-commit');
        } catch (\Exception $e) {
            return 'Gagal mengambil riwayat perubahan.';
        }
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }
    }
}
