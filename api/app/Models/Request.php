<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * @package App\Models
 * @property integer $id
 * @property Service $service
 */
class Request extends Model implements Ownerable
{

    protected $fillable = ['service_id', 'user_id'];

    public function owner()
    {
        return $this->hasOne(User::class);
    }

    public function ownedBy(User $owner): bool
    {
        return $this->owner->id === $owner->id;
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }
}
