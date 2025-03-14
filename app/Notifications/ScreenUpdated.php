<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class ScreenUpdated extends Notification
{
    public function via(User $notifiable): array
    {
        return [
            'broadcast'
        ];
    }

    public function toArray(User $notifiable): array
    {
        return [
            'refresh' => 'screen',
        ];
    }
}
