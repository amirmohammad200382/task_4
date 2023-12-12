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
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_name' => fake()->username(),
            'first_name' =>fake()->firstname(),
            'last_name' =>fake()->lastname(),
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(2,40),
            'password' => fake()->password(),
            'postcode' => fake()->postcode(),
            'address' =>fake()->address(),
            'image' =>fake()->image(),
            'province'=>fake()->city(),
            'country' =>fake()->country(),
            'city' =>fake()->city(),
            'gender' =>fake()->randomElement(['male' , 'female']),
            'phone_number' =>fake()->phonenumber(),
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
}
