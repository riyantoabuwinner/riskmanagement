<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleRequestSubmitted extends Notification
{
    use Queueable;

    private $roleRequest;

    public function __construct($roleRequest)
    {
        $this->roleRequest = $roleRequest;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'role_request_submitted',
            'role_request_id' => $this->roleRequest->id,
            'message' => 'Terdapat pengajuan role baru (' . $this->roleRequest->requested_role . ') dari ' . ($this->roleRequest->user->name ?? 'User'),
            'url' => route('role-requests.index')
        ];
    }
}
