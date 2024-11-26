<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'body' => $this->faker->sentence,
        'commentable_id' => $this->faker->numberBetween(1, 100),
        'commentable_type' => $this->faker->randomElement(['App\Models\Post', 'App\Models\Video', 'App\Models\Picture']),
        'author_id' => User::factory(),
        ];
    }
}
