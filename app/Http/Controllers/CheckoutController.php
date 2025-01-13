<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        if(!$request->input('selected_items', [])){
            return back()->with('error', 'Anda belum memilih barang.');
        }

        if(!$request->input('pickup_date')){
            return back()->with('error', 'Tanggal awal harus diisi.');
        }

        if(!$request->input('return_date')){
            return back()->with('error', 'Tanggal akhir harus diisi.');
        }

        setlocale(LC_TIME, 'id_ID.UTF-8');
        Carbon::setLocale('id');
        $idUser = Auth::User()->id;

        $selectedItems = $request->input('selected_items', []);

        $pickupDate = Carbon::parse($request->input('pickup_date'));
        $returnDate = Carbon::parse($request->input('return_date'));

        if ($returnDate->lt($pickupDate->copy()->addDays(2))) {
            return back()->with('error', 'Tanggal akhir harus minimal 2 hari setelah tanggal awal.');
        }

        $items = Cart::where('user_id', $idUser)
        ->whereIn('id', $selectedItems)
        ->with('product')
        ->get();

        // Ambil nama pengguna pertama (asumsi user_id sama untuk semua barang di cart)
        $user = $items->first()?->user;
        $userName = $user ? $user->firstname . ' ' . $user->lastname : 'Guest';

        if ($returnDate->gte($pickupDate)) {
            $days = $pickupDate->diffInDays($returnDate);
            $totalDays = $days * 5000;
        }
        else {
            return back()->with('error', 'Tanggal akhir harus lebih besar atau sama dengan tanggal mulai.');
        }

        $pickupDateFormatted = $pickupDate->translatedFormat('d F Y');
        $returnDateFormatted = $returnDate->translatedFormat('d F Y');

        $total = 0;
        $subtotal = 0;
        $grandtotal = 0;
        $pajak = 0;
        foreach ($items as $item) {
            $item->total = $item->quantity * $item->product->price;
            $total += $item->total;
            $subtotal = $total + $totalDays;
            $pajak = ($subtotal * 0.11);
            $grandtotal = $subtotal + $pajak;
        }


        return view('checkout', [
            'items' => $items,
            'pickup' => $pickupDateFormatted,
            'return' => $returnDateFormatted,
            'days' => $days,
            'totalDays' => $totalDays,
            'userName' => $userName,
            'total' => $total,
            'subtotal' => $subtotal,
            'grandtotal' => $grandtotal,
        ]);
    }
}
