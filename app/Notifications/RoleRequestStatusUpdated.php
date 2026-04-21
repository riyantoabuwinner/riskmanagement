<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\RoleRequest;

class RoleRequestStatusUpdated extends Notification
{
    use Queueable;

    public $roleRequest;
    public $message;

    public function __construct(RoleRequest $roleRequest, $message)
    {
        $this->roleRequest = $roleRequest;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'role_request_status_updated',
            'role_request_id' => $this->roleRequest->id,
            'message' => $this->message,
            'url' => route('dashboard')
        ];
    }
}
