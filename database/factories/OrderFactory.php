<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
          'user_id' =>function() {
            return User::factory()->create()->id;
          },
            'title' => 'order' . fake()->unique()->randomDigitNot(0),
            'total_price' => 0,
        ];
    }
}
