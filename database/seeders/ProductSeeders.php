<?php

namespace Database\Seeders;

use App\Models\ProductRentModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductRentModel::factory(10)->create();
    }
}
