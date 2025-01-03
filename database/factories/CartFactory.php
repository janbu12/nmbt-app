<?php
namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\ProductRentModel as Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'name' => $this->faker->words(3, true), // Nama produk
            'image_url' => $this->faker->imageUrl(200, 200, 'hiking equipment'), // URL gambar
            'price' => $this->faker->randomFloat(2, 100000, 500000), // Harga produk (100k - 500k)
            'quantity' => $this->faker->numberBetween(1, 10), // Jumlah produk
        ];
    }
}
