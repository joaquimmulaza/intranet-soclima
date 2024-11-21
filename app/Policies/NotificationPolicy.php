<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // NotificationPolicy.php
    public function view(User $user, Notification $notification)
    {
        return $notification->user_id === $user->id;
    }

}
