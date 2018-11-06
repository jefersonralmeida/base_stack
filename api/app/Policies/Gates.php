<?php

namespace App\Policies;

use App\Models\Ownerable;
use App\Models\User;

class Gates
{

    /**
     * Allows users with the admin role.
     *
     * @param User $loggedUser
     * @return bool
     */
    public function admin(User $loggedUser)
    {
        return array_search('admin', $loggedUser->roles) !== false;
    }

    /**
     * Allows users with the customer or admin roles.
     *
     * @param User $loggedUser
     * @return bool
     */
    public function customer(User $loggedUser)
    {
        return !empty(array_intersect(['admin', 'customer'], $loggedUser->roles));
    }

    /**
     * Allows users with the provider or admin roles.
     *
     * @param User $loggedUser
     * @return bool
     */
    public function provider(User $loggedUser)
    {
        return !empty(array_intersect(['admin', 'provider'], $loggedUser->roles));
    }

    /**
     * Allows users that are the owner of the subject (or admins)
     *
     * @param User $loggedUser
     * @param Ownerable $subject
     * @return bool
     */
    public function owner(User $loggedUser, Ownerable $subject)
    {
        return $subject->owner->id === $loggedUser->id || array_search('admin', $loggedUser->roles) !== false;
    }

    /**
     * Allows only the user itself and admins.
     *
     * @param User $loggedUser
     * @param User $user
     * @return bool
     */
    public function user(User $loggedUser, User $user)
    {
        return $user->id === $loggedUser->id || array_search('admin', $loggedUser->roles) !== false;
    }
}
