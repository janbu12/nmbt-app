<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = \App\Models\Review::class;

    public function definition(): array
    {
        return [
            'product_id' => null, // Akan diisi oleh Seeder
            'user_id' => null,    // Akan diisi oleh Seeder
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->text(100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
