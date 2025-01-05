<?php

namespace App\Http\Controllers;

use App\Models\ProductRentModel as Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil 3 produk teratas menggunakan getTopThreeProductsAttribute
        $topThreeProducts = Product::first()->top_three_products; // Atau bisa disesuaikan jika produk tertentu

        // Kirim data ke view
        return view('welcome', compact('topThreeProducts'));
    }
}
