<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\RentDetailsModel;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua RentDetails yang terkait dengan transaksi Rent berstatus 'done'
        $completedRentDetails = RentDetailsModel::whereHas('rent', function ($query) {
            $query->where('status_rent', 'done');
        })->get();

        // Iterasi setiap RentDetails untuk membuat review
        foreach ($completedRentDetails as $rentDetail) {
            Review::factory()->create([
                'product_id' => $rentDetail->product_id, // Produk dari RentDetails
                'user_id' => $rentDetail->rent->user_id, // User dari Rent
            ]);
        }
    }
}
