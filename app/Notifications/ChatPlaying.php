<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class ChatPlaying extends Notification
{
    public ?string $flash = null;
    public ?string $link = null;

    public function __construct(?string $flash = null, ?string $link = null)
    {
        $this->flash = $flash;
        $this->link = $link;
    }

    public function via(User $notifiable): array
    {
        return [
            'broadcast'
        ];
    }

    public function toArray(User $notifiable): array
    {
        return [
            'flash' => $this->flash,
            'link' => $this->link,
        ];
    }
}
