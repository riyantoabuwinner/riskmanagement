<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendOverdueMitigationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-overdue-mitigation-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for overdue risk mitigations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueMitigations = \App\Models\Mitigation::where('status', '!=', 'Completed')
            ->where('deadline', '<', now())
            ->with(['risk.createdBy'])
            ->get();

        foreach ($overdueMitigations as $mitigation) {
            $user = $mitigation->risk->createdBy ?? null;
            if ($user) {
                // In a real app, send Mail/Notification here.
                // For now, just log it to console.
                $this->info("Overdue mitigation for risk '{$mitigation->risk->event}': Plan '{$mitigation->plan}' assigned to {$mitigation->pic}. Notify {$user->email}.");
            }
        }

        $this->info('Overdue mitigation checks completed.');
    }
}
