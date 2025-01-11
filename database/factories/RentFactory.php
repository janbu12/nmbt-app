<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Rent::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $pickupDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $createdAt = $this->faker->dateTimeBetween('-365 days', 'now');

        return [
            'user_id' => $user->id,
            'pickup_date' => $createdAt,
            'return_date' => (clone $createdAt )->modify('+2 days'),
            'status_rent' => $this->faker->randomElement(['process', 'ready_pickup', 'renting', 'done']),
            'total_price' => 0,
            'payment_method' => 'qris',
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
