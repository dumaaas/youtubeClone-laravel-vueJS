<?php

namespace App\Listeners\Users;

class CreateUserChannel
{
    public function handle($event)
    {
        $event->user->channel()->create([
            'name' => $event->user->name
        ]);
    }
}
