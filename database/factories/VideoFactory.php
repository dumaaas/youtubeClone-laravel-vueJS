<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'channel_id' => function() {
                return Channel::factory()->create()->id;
            },
            'views' => $this->faker->numberBetween(1, 10000),
            'thumbnail' => $this->faker->imageUrl(),
            'percentage' => 100,
            'title' => $this->faker->title(),
            'description' => $this->faker->sentence(10),
            'path' => $this->faker->word()
        ];

    }
}
