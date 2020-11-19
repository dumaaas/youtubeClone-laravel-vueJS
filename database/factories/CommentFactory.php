<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'body' => $this->faker->sentence(6),
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'video_id' => function() {
                return Video::factory()->create()->id;
            },
            'comment_id' => null
        ];

    }
}
