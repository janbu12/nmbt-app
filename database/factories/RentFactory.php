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
    $returnDate = (clone $pickupDate)->modify('+' . $this->faker->numberBetween(1, 10) . ' days'); // Durasi random antara 1-10 hari
    $createdAt = $this->faker->dateTimeBetween('-365 days', 'now');

    // Hitung jumlah hari
    $daysDifference = $pickupDate->diff($returnDate)->days;

    return [
        'user_id' => $user->id,
        'pickup_date' => $pickupDate,
        'return_date' => $returnDate,
        'status_rent' => $this->faker->randomElement(['process', 'ready_pickup', 'renting', 'done']),
        'total_price' => $daysDifference * $this->faker->numberBetween(10000, 50000), // Misalnya 10rb-50rb/hari
        'payment_method' => 'qris',
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
        'days' => $daysDifference, // Tambahkan jumlah hari jika diperlukan
    ];
}
}
