<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel 'carts'
        $cartItems = Cart::all();

        // Kirim data ke view
        return view('cart', [
            'cartItems' => $cartItems,
        ]);
    }
}
