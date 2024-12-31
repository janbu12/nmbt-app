<?php

namespace Database\Factories;
use App\Models\ProductRentModel as Product;
use App\Models\Rent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RentDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\RentDetailsModel::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $rent = Rent::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'rent_id' => $rent->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'subtotal' => $quantity * $product->price,
        ];
    }
}
