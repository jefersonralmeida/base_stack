<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

trait NotificationTrait
{

    /**
     * This function must return the array of lines for the message.
     *
     * @param $notifiable
     * @return array
     */
    abstract protected function message($notifiable): array;

    /**
     * Get the mail representation of the notification.
     * @param $notifiable
     * @return MailMessage
     * @internal param mixed $notifiable
     */
    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage();

        foreach ($this->message($notifiable) as $item) {
            $method = array_shift($item);
            $mailMessage->$method(...$item);
        }

        return $mailMessage;

    }

    /**
     * Get the array representation of the notification.
     * @param $notifiable
     * @return array
     * @internal param mixed $notifiable
     */
    public function toArray($notifiable)
    {
        return $this->message($notifiable);
    }

    /**
     * Get the broadcast object of the notification.
     * @param $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->message($notifiable));
    }
}
