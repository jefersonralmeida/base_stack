<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RequestNotification extends Notification implements ShouldQueue
{
    use Queueable, NotificationTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Create a new notification instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * @return array
     */
    protected function message(): array
    {
        $url = url('/requests/' . $this->request->id);
        return [
            ['subject', __('notifications.requestNotification.title')],
            ['line', __('notifications.requestNotification.line1')],
            ['action', __('notifications.requestNotification.action'), $url],
            ['line', __('notifications.footer')]
        ];
    }
}
