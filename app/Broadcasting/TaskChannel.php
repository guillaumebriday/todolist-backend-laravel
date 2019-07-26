<?php

namespace App\Broadcasting;

use App\Models\User;

class TaskChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, int $id): bool
    {
        return $user->id == $id;
    }
}
