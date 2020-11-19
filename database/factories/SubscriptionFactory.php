<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'channel_id' => function() {
                return Channel::factory()->create()->id;
            },
        ];
    }
}
