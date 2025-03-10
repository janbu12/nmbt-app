<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductRentModel as Product;
use App\Models\Rent;
use App\Models\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // private $cartItems = [];

    public function index()
    {
        $idUser = Auth::user()->id; // Dapatkan user login

        // Ambil semua cart items untuk user
        $carts = Cart::with(['user', 'product'])
            ->where('user_id', $idUser)
            ->get();
        $rules = Rule::findOrFail(1);

        // Array untuk menyimpan nama produk yang stoknya habis
        $outOfStockProducts = [];

        // Loop untuk memeriksa stok dan menghapus item yang habis
        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                // Jika stok habis, hapus item dari cart
                $outOfStockProducts[] = $cart->product->name; // Simpan nama produk
                $cart->delete(); // Hapus item dari cart
            }
        }

        // Ambil kembali cart items yang tersisa
        $availableCarts = Cart::with(['user', 'product'])
            ->where('user_id', $idUser)
            ->orderBy('id', 'desc')
            ->get();

        $subtotal = $availableCarts->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Jika ada produk yang habis, simpan pesan
        $message = '';
        if (!empty($outOfStockProducts)) {
            $message = 'Item ' . implode(', ', $outOfStockProducts) . ' is out of stock.';
        }

        return view('cart.index', [
            'cartItems' => $availableCarts,
            'subtotal' => $subtotal,
            'message' => $message,
            'rules' => $rules,
        ]);
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Success delete item from cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found.');
    }

    public function update(Request $request, $id)
    {
        // Simpan selected_items ke dalam session
        if ($request->has('selected_items')) {
            session(['selected_items' => $request->input('selected_items', [])]);
        }

        $cartItem = Cart::find($id);

        $product = Product::find($cartItem->product_id);

        if ($cartItem) {
            if ($request->quantity < 1) {
                return redirect()->route('cart.index')->with('error', 'Quantity must be greater than 0.');
            }

            if ($request->quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'The quantity of  ' . $product->name .  ' is greater than the stock.');
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return redirect()->route('cart.index')->with('success', 'Success update item in cart.');
        }

        return redirect()->route('cart.index')->with('error', 'Item not found.');
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
            return back()->with('error', 'Return date must be greater or equal to pickup date.');
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

        $product = Product::find($id);

        if($request->quantity > $product->stock){
            return back()->with('error', 'The quantity of ' . $product->name .  ' is greater than the stock.');
        }

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
