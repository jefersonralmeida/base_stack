<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RequestConfirmation extends Notification implements ShouldQueue
{
    use Queueable, NotificationTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Create a new notification instance.
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
        return ['mail'];
    }

    /**
     * This function must return the array of lines for the message.
     * @return array
     * @internal param $notifiable
     */
    protected function message(): array
    {

        $url = url('/requests/' . $this->request->id);

        return [
            ['subject', __('notifications.requestConfirmation.title')],
            ['line', __('notifications.requestConfirmation.line1')],
            ['action', __('notifications.requestConfirmation.action'), $url],
            ['line', __('notifications.footer')]
        ];
    }
}
