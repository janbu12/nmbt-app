<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Buat beberapa pengguna
         $users = User::factory()->count(5)->create();

         // Buat beberapa item cart untuk setiap pengguna
         foreach ($users as $user) {
             Cart::factory()
                 ->count(rand(2, 5)) // Setiap user memiliki 2 hingga 5 item di cart
                 ->create([
                     'user_id' => $user->id,
                 ]);
         }
    }
}
