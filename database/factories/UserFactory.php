<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'nickname' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'github_id' => null,
            'github_token' => null,
            'avatar' => null,
            'bio' => fake()->optional(0.7)->sentence(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a GitHub user.
     */
    public function github(): static
    {
        return $this->state(fn (array $attributes) => [
            'github_id' => fake()->unique()->numerify('########'),
            'avatar' => fake()->imageUrl(200, 200, 'people'),
            'password' => null,
        ]);
    }
}
