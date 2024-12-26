<?php
namespace Database\Factories;

use App\Models\Cart;
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
        return [
            'user_id' => \App\Models\User::factory(), // ID user (dihubungkan dengan factory User)
            'name' => $this->faker->words(3, true), // Nama produk
            'image_url' => $this->faker->imageUrl(200, 200, 'hiking equipment'), // URL gambar
            'price' => $this->faker->randomFloat(2, 100000, 500000), // Harga produk (100k - 500k)
            'quantity' => $this->faker->numberBetween(1, 10), // Jumlah produk
        ];
    }
}
