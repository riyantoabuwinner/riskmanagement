<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Mitigation;

class MitigationDeadlineApproaching extends Notification
{
    use Queueable;

    public $mitigation;
    public $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct(Mitigation $mitigation, $daysLeft)
    {
        $this->mitigation = $mitigation;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mitigation_deadline',
            'mitigation_id' => $this->mitigation->id,
            'mitigation_strategy' => $this->mitigation->strategy,
            'days_left' => $this->daysLeft,
            'message' => 'Tenggat waktu mitigasi "' . substr($this->mitigation->strategy, 0, 30) . '..." tersisa ' . $this->daysLeft . ' hari lagi.',
            'url' => route('mitigations.edit', $this->mitigation->id)
        ];
    }
}
