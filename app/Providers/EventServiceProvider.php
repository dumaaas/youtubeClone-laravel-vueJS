<?php

namespace App\Providers;

use App\Listeners\Users\CreateUserChannel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateUserChannel::class,
        ],
    ];

    public function boot()
    {
        //
    }
}
