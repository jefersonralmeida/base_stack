<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

/**
 * Class Notification
 * @package App\Models
 * @property array $data
 * @property string $read_at
 */
class Notification extends DatabaseNotification implements Ownerable
{
    protected $hidden = [
        'type', 'notifiable_type', 'notifiable_id'
    ];

    public function owner()
    {
        return $this->notifiable();
    }

    public function ownedBy(User $owner): bool
    {
        return $this->owner->id === $owner->id;
    }
}
