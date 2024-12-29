<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Tenda'],
            ['category_name' => 'Tas dan Ransel'],
            ['category_name' => 'Sepatu'],
            ['category_name' => 'Matras'],
            ['category_name' => 'Kursi Lipat'],
            ['category_name' => 'Kompor'],
            ['category_name' => 'Jaket'],
            ['category_name' => 'Flysheet'],
        ];

        DB::table('categories')->insert($categories);
    }
}
