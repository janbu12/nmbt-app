<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\Can;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            CategorySeeders::class,
            ProductSeeders::class,
            RentSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            RuleSeeder::class
        ]);
    }
}
