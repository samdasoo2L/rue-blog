<?php

namespace Database\Factories;

use App\Models\Post;
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
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'content' => fake()->paragraphs(rand(1, 3), true),
        ];
    }

    /**
     * Indicate that the comment is short.
     */
    public function short(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the comment is long.
     */
    public function long(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => fake()->paragraphs(rand(4, 6), true),
        ]);
    }
}
