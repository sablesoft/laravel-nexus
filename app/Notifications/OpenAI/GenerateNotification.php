<?php

namespace App\Notifications\OpenAI;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GenerateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $userId;

    protected array $result;
    protected string $message;
    protected array $context;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $result, int $userId)
    {
        Log::debug('[GenerateNotification] Init', [
            'result' => $result,
            'user_id' => $userId
        ]);
        $this->result = $result;
        $this->userId = $userId;
        if ($result['success']) {
            $this->message = __('Your generate task has been completed');
        } else {
            $this->message = __('Your generate task has been failed');
            $this->context[] = 'We sincerely regret this. Try a different context or contact us for help';
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
//            'mail',
//            'database',
            'broadcast'
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $notifiable
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Generate Task')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->message);
        if ($this->result['success']) {
            $message->success();
        } else {
            $message->error();
        }
        foreach ($this->context as $line) {
            $message->line($line);
        }
        $message->line('Thank you for using our application!');

        $message->tag('generate');

        return $message;
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
            'refresh' => $this->result['refresh'] ?? null,
            'flash' => $success ? 'message' : 'error',
            'message' => $this->message,
            'success' => $success,
        ];
    }
}
