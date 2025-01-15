<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // private $cartItems = [];

    public function index()
    {
        $idUser = Auth::user()->id; // Dapatkan user login

        $carts = Cart::with(['user', 'product'])
        ->where('user_id', $idUser)
        ->get();

        $subtotal = $carts->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });


        return view('cart.index', [
            'cartItems' => $carts,
            'subtotal' => $subtotal,
        ]);
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id); // Cari item berdasarkan ID

        if ($cartItem) {
            $cartItem->delete(); // Hapus item dari database
            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        // Simpan selected_items ke dalam session
        if ($request->has('selected_items')) {
            session(['selected_items' => $request->input('selected_items', [])]);
        }

        $cartItem = Cart::find($id);

        if ($cartItem) {
            if ($request->quantity < 1) {
                return redirect()->route('cart.index')->with('error', 'Jumlah barang tidak boleh kurang dari 1.');
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return redirect()->route('cart.index')->with('success', 'Jumlah barang berhasil diperbarui.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }


    public function calculatePrice(Request $request)
    {
        $startDate = Carbon::parse($request->input('pickup_date'));
        $endDate = Carbon::parse($request->input('return_date'));
        $pricePerDay = 5000;

        if ($endDate->gte($startDate)) {
            $days = $startDate->diffInDays($endDate);
            $totalPrice = $days * $pricePerDay;
        } else {
            return back()->with('error', 'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai.');
        }

        return view('cart.index', [
            'days' => $days,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function addToCart(Request $request, $id){
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $userId = Auth::user()->id;

        $existingCart = Cart::where('user_id', $userId)
        ->where('product_id', $id)
        ->first();

        if ($existingCart) {
            // Jika produk sudah ada, tambahkan quantity baru ke quantity yang ada
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            // Jika produk belum ada, buat entri baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Add To Cart Successfully!');
        // return dd($cart);
    }

}
