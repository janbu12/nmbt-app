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
            ['category_name' => 'Peralatan Memasak'],
            ['category_name' => 'Lampu dan Senter'],
            ['category_name' => 'Peralatan Tidur'],
            ['category_name' => 'Pakaian Outdoor'],
            ['category_name' => 'Sepatu dan Sandal'],
            ['category_name' => 'Peralatan Survival'],
            ['category_name' => 'Alat Kebersihan'],
            ['category_name' => 'Aksesoris Lainnya'],
        ];

        DB::table('categories')->insert($categories);
    }
}
