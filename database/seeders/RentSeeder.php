<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rent;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rent::factory(10)
            ->has(
                \App\Models\RentDetailsModel::factory()
                    ->count(3), // Setiap Rent memiliki 3 RentDetails
                'rent_details'
            )
            ->create()
            ->each(function ($rent) {
                // Hitung total_price berdasarkan subtotal di RentDetails
                $totalPrice = $rent->rent_details->sum(function ($detail) {
                    return $detail->quantity * $detail->product->price; // Harga dari produk
                });

                $rent->update(['total_price' => $totalPrice]);
            });
    }
}
