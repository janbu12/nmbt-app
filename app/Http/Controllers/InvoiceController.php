<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\Rent;
use App\Models\RentDetailsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
class InvoiceController extends Controller
{
    private function generateSnapToken($data)
    {

    }

    public function index(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                 'pickup_date' => 'required',
                'return_date' => 'required',
                'selected_items' => 'required|array|min:1',
            ],
            [
                'pickup_date.required' => 'Tanggal awal harus diisi.',
                'return_date.required' => 'Tanggal akhir harus diisi.',
                'selected_items.required' => 'Anda harus memilih minimal satu barang.',
            ]
        );

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


        return view('cart.invoice', [
            'items' => $items,
            'pickup' => Carbon::parse($pickupDate)->format('Y-m-d'),
            'return' => Carbon::parse($returnDate)->format('Y-m-d'),
            'days' => $days,
            'totalDays' => $totalDays,
            'userName' => $userName,
            'total' => $total,
            'subtotal' => $subtotal,
            'grandtotal' => $grandtotal,
            'email' => Auth::User()->email,
        ]);
    }

    public function pay (Request $request)
    {
        // dd($request);

        $request->validate([
            'pickup_date' => 'required|date',
            'return_date' => 'required|date',
            'selected_items' => 'required|array',
            'grandtotal' => 'required|numeric',
        ]);

        $rent = Rent::create([
            'user_id' => Auth::id(),
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'total_price' => $request->grandtotal,
            'status' => 'unpaid',
        ]);

        foreach ($request->selected_items as $itemId) {
            $item = Cart::find($itemId);
            RentDetailsModel::create([
                'rent_id' => $rent->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'subtotal' => $item->product->price,
            ]);
        }

        Cart::where('user_id', Auth::id())->whereIn('id', $request->selected_items)->delete();

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $grossAmount = intval(round($request->grandtotal));

        Log::info('Gross Amount: ' . $grossAmount);

        $params = [
            'transaction_details' => [
                'order_id' => $rent->id,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $request->user()->firstname,
                'last_name' => $request->user()->lastname,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone,
            ],
        ];

        Log::info('Params to Midtrans:', $params);

        try {
            // Dapatkan token pembayaran
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $rent->snap_token = $snapToken;
            $rent->save();

            return response()->json(['status' => 'success', 'snapToken' => $snapToken, 'rent' => $rent]);
        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan pesan kesalahan
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getPaymentToken(Request $request, $id)
    {
        $rent = Rent::findOrFail($id);

        $client = new Client();
        $url = 'https://api.sandbox.midtrans.com/v2/' . $id . '/status';

        $response = $client->request('GET', $url, [
            'headers' => [
              'accept' => 'application/json',
              'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            ],
          ]);

        // dd($response);
        $data = json_decode($response->getBody(), true);
        $statusCode = $data['status_code'];

        if($statusCode == 404){
            // Handle if transaction is not onPending

            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $rent->id,
                    'gross_amount' => $rent->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->firstname,
                    'last_name' => $request->user()->lastname,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                ],
            ];

            try {
                // Dapatkan token pembayaran
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $rent->snap_token = $snapToken;
                $rent->save();

                return response()->json(['status' => 'success', 'snapToken' => $rent->snap_token]);
            } catch (\Exception $e) {
                // Tangani kesalahan dan kembalikan pesan kesalahan
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        else if(@isset($data['transaction_status']) && $data['transaction_status'] == 'expire') {
            // Handle if transaction expired

            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $rent->id,
                    'gross_amount' => $rent->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->firstname,
                    'last_name' => $request->user()->lastname,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                ],
            ];

            try {
                // Dapatkan token pembayaran
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $rent->snap_token = $snapToken;
                $rent->save();

                return response()->json(['status' => 'success', 'snapToken' => $rent->snap_token, 'transaction_status' => $data['transaction_status']]);
            } catch (\Exception $e) {
                // Tangani kesalahan dan kembalikan pesan kesalahan
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }

        if ($rent->status_rent !== 'unpaid') {
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak dapat dibayar.'], 400);
        }

        return response()->json(['status' => 'success', 'snapToken' => $rent->snap_token, 'url' => $url, 'response' => $data]);
    }

    public function cancel($id)
    {
        $rent = Rent::findOrFail($id);
        $rent->status_rent = 'cancelled';
        $rent->save();

        return response()->json(['status' => 'success', 'message' => 'Pesanan berhasil dibatalkan.']);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $rent = Rent::findOrFail($id);
        $rent->payment_method = $request->payment_method;
        $rent->save();

        return response()->json(['status' => 'success', 'message' => 'Payment method updated successfully.']);
    }

    public function sendToEmail(Request $request)
    {
        $request->validate([
            'user_name' =>'required|string',
            'pickup_date' =>'required',
            'return_date' =>'required',
            'items' =>'required|array',
            'grandtotal' =>'required|numeric',
        ]);

        $userName = $request->input('user_name');
        $pickup = $request->input('pickup_date');
        $return = $request->input('return_date');
        $grandtotal = $request->input('grandtotal');
        $orderId = $request->input('order_id');

        // Ambil detail sewa berdasarkan order_id
        $rentDetails = RentDetailsModel::where('rent_id', $orderId)->with('product')->get();

        // Hitung total untuk setiap item
        foreach ($rentDetails as $detail) {
            $detail->total = $detail->quantity * $detail->product->price; // Hitung total berdasarkan kuantitas dan harga produk
        }

        Mail::to($request->input('email'))->send(new InvoiceMail($userName, $pickup, $return, $rentDetails, $grandtotal));

        return response()->json(['status' => 'success']);
    }

}
