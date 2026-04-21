<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mitigation;
use App\Models\User;
use App\Notifications\MitigationDeadlineApproaching;
use Carbon\Carbon;

class CheckMitigationDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risks:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek deadline mitigasi dan kirim notifikasi peringatan dini';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa deadline mitigasi...');

        // Kita cari mitigasi yang belum selesai dan target waktunya mendekati
        // Kita kirim peringatan pada H-7 dan H-3

        $deadlines = [7, 3, 1];

        foreach ($deadlines as $days) {
            $targetDate = Carbon::now()->addDays($days)->format('Y-m-d');

            $mitigations = Mitigation::where('target_waktu', $targetDate)
                ->where('status', '!=', 'Selesai')
                ->get();

            foreach ($mitigations as $mitigation) {
                $risk = $mitigation->risk;
                if ($risk && $risk->created_by) {
                    $owner = User::find($risk->created_by);
                    if ($owner) {
                        // Check if notification already sent today for this mitigation to avoid spam
                        // (Optional, but good practice in real app)

                        $owner->notify(new MitigationDeadlineApproaching($mitigation, $days));
                        $this->line("Notifikasi dikirim ke {$owner->name} untuk mitigasi ID: {$mitigation->id} (H-{$days})");
                    }
                }
            }
        }

        $this->info('Pemeriksaan deadline selesai.');
    }
}
