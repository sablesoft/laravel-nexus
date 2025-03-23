<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ScaleImageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected array $result;
    protected string $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $result)
    {
        Log::debug('[ScaleImageNotification] Init', [
            'result' => $result,
        ]);
        $this->result = $result;
        if (!empty($result['success'])) {
            $this->message = __('Your image scaling has been completed');
        } else {
            $this->message = __('Your image scaling has been failed!');
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param User $notifiable
     * @return array
     */
    public function via(User $notifiable): array
    {
        return [
            'broadcast'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param User $notifiable
     * @return array
     */
    public function toArray(User $notifiable): array
    {
        $success = $this->result['success'];
        return [
            'refresh' => $success ? 'images' : null,
            'flash' => $this->message,
            'link' => $this->result['link'] ?? null,
            'debug' => $this->result['debug'] ?? null,
            'success' => $success, // todo - flash variants
        ];
    }
}
