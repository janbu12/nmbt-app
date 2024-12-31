<?php

namespace Database\Factories;

use App\Models\ProductRentModel as Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Review::class;

    /**
     * Configure the model's factory.
     *
     * @return void
     */

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->text(100),
        ];
    }
}
