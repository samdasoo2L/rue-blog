<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => fake()->paragraphs(rand(3, 8), true),
            'slug' => Str::slug($title),
        ];
    }

    /**
     * Indicate that the post is short.
     */
    public function short(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => fake()->paragraphs(2, true),
        ]);
    }

    /**
     * Indicate that the post is long.
     */
    public function long(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => fake()->paragraphs(rand(10, 20), true),
        ]);
    }
}
