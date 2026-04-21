<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Risk;

class RiskStatusUpdated extends Notification
{
    use Queueable;

    public $risk;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Risk $risk, $oldStatus, $newStatus)
    {
        $this->risk = $risk;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
            'type' => 'risk_status_updated',
            'risk_id' => $this->risk->id,
            'risk_name' => $this->risk->risk_statement,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Status risiko "' . substr($this->risk->risk_statement, 0, 30) . '..." berubah dari ' . $this->oldStatus . ' menjadi ' . $this->newStatus . '.',
            'url' => route('risks.index', ['risk_id' => $this->risk->id])
        ];
    }
}
