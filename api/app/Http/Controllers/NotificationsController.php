<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    /**
     * Lists all notifications for an user
     *
     * @param User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->notifications;
    }

    /**
     * Lists unread notifications for an user
     *
     * @param User $user
     * @return mixed
     */
    public function unread(User $user)
    {
        return $user->unreadNotifications;
    }

    /**
     * Lists read notifications for an user
     *
     * @param User $user
     * @return mixed
     */
    public function read(User $user)
    {
        return $user->readNotifications;
    }

    /**
     * Shows one specific notification based on the notification_id
     *
     * @param Notification $notification
     * @return Notification
     */
    public function show(Request $request, Notification $notification)
    {

        // if the owner is reading the notification, mark it as read.
        if ($notification->ownedBy($request->user())) {
            $notification->markAsRead();
        }

        return $notification;
    }
}
