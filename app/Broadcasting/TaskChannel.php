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
     *
     * @param  \App\User  $user
     * @param  int  $id
     * @return array|bool
     */
    public function join(User $user, $id)
    {
        return $user->id == $id;
    }
}
