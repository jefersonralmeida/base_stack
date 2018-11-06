<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $email_verified_at
 * @property string $verify_email_token
 * @property array $roles
 * @property Notification[] $notifications
 * @property Notification[] $unreadNotifications
 * @property Notification[] $readNotifications
 * @property Service[] $services
 */
class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, Notifiable, SoftDeletes, MustVerifyEmail;

    protected $dates = ['email_verified_at', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verify_email_token', 'roles'
    ];

    protected $casts = [
        'roles' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'verify_email_token',
    ];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
//    public function receivesBroadcastNotificationsOn()
//    {
//        return 'users.' . $this->id;
//    }

    /**
     * Get all the user's notifications
     * @return \Illuminate\Database\Query\Builder
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

}
