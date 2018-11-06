<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @package App\Models
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property User[] $users
 */
class Service extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
