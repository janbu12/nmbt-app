<?php

namespace Database\Factories;

use App\Models\ProductRentModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = ProductRentModel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'category_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->words(25, true),
            'teaser' => $this->faker->words(8, true),
            'price' => $this->faker->randomFloat(2, 100000, 500000),
            'stock' => $this->faker->numberBetween(1, 10),
        ];
    }
}
