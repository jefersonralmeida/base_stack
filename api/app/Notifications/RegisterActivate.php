<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RegisterActivate extends Notification implements ShouldQueue
{
    use Queueable, NotificationTrait;

    /**
     * @var bool
     */
    protected $resend;

    /**
     * Create a new notification instance.
     * @param bool $resend
     */
    public function __construct(bool $resend = false)
    {
        $this->resend = $resend;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  User $notifiable
     * @return array
     */
    public function via(User $notifiable)
    {
        $channels = ['mail'];
        if (!$this->resend) {
            $channels[] = 'database';
        }
        return $channels;
    }

    /**
     * This function must return the array of lines for the message.
     *
     * @param $notifiable
     * @return array
     */
    protected function message($notifiable): array
    {
        $url = url('/user/activate/' . $notifiable->verify_email_token);

        return [
            ['subject', __('notifications.registerActivate.title')],
            ['line', __('notifications.registerActivate.line1')],
            ['action', __('notifications.registerActivate.action'), $url],
            ['line', __('notifications.footer')]
        ];
    }
}
