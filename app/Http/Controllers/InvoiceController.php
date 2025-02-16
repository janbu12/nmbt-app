<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\ProductRentModel as Product;
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
                'pickup_date.required' => 'Pickup date should be filled.',
                'return_date.required' => 'Return date should be filled.',
                'selected_items.required' => 'You should select at least one item.',
            ]
        );

        setlocale(LC_TIME, 'id_ID.UTF-8');
        Carbon::setLocale('id');
        $now = Carbon::now( );
        $operationalClose = Carbon::today()->setHour(19)->setMinute(0);

        // dd($now, $operationalClose);

        if ($now->greaterThan($operationalClose)) {
            return back()->with('error', 'Orders cannot be placed after 19:00 WIB. Please order earlier.');
        }


        $idUser = Auth::User()->id;

        $selectedItems = $request->input('selected_items', []);

        $pickupDate = Carbon::parse($request->input('pickup_date'));
        $returnDate = Carbon::parse($request->input('return_date'));

        if ($returnDate->lt($pickupDate->copy()->addDays(1))) {
            return back()->with('error', 'Return date should be at least 1 days after pickup date.');
        }

        $items = Cart::where('user_id', $idUser)
        ->whereIn('id', $selectedItems)
        ->with(['product', 'product.images'])
        ->get();

        // Ambil nama pengguna pertama (asumsi user_id sama untuk semua barang di cart)
        $user = $items->first()?->user;
        $userName = $user ? $user->firstname . ' ' . $user->lastname : 'Guest';

        if ($returnDate->gte($pickupDate)) {
            $days = $pickupDate->diffInDays($returnDate);
            $totalDays = $days * 5000;
        }
        else {
            return back()->with('error', 'Return date should be greater or equal than pickup date.');
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
            'tax' => $pajak,
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
            'tax' => 'required|numeric',
        ]);

        $rent = Rent::create([
            'user_id' => Auth::id(),
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'total_price' => $request->grandtotal,
            'status' => 'unpaid',
        ]);

        $itemDetails = [];
        foreach ($request->selected_items as $index => $itemId) {
            $item = Cart::find($itemId);

            // Pastikan item ditemukan
            if ($item) {
                // Buat detail sewa
                RentDetailsModel::create([
                    'rent_id' => $rent->id,
                    'product_id' => $item->product_id,
                    'quantity' => $request->quantities[$index],
                    'subtotal' => $item->product->price * $request->quantities[$index],
                ]);

                // Kurangi stok produk
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $request->quantities[$index];
                    $product->save();
                }

                $itemDetails[] = [
                    'id' => $item->product_id, // ID produk
                    'price' => intval(round($item->product->price)), // Harga produk
                    'quantity' => $request->quantities[$index], // Kuantitas
                    'name' => $item->product->name, // Nama produk
                ];
            }
        }

        $taxAmount = intval(round($request->tax));
        $totalDays = intval(round($request->totalDays));

        // Harga Sewa
        $itemDetails[] = [
            'id' => 'RENTPRICE',
            'price' => intval(round($totalDays)),
            'quantity' => 1,
            'name' => 'Rent Price',
        ];

        // Pajak
        $itemDetails[] = [
            'id' => 'TAX',
            'price' => intval(round($taxAmount)),
            'quantity' => 1,
            'name' => 'Tax',
        ];

        Cart::where('user_id', Auth::id())->whereIn('id', $request->selected_items)->delete();

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $grossAmount = intval(round($request->grandtotal));

        Log::info('Gross Amount: ' . $grossAmount);

        $params = [
            'transaction_details' => [
                'order_id' => 'order-' . $rent->id . '-' . $rent->created_at,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $request->user()->firstname,
                'last_name' => $request->user()->lastname,
                'email' => $request->user()->email,
                'phone' => $request->user()->phone,
            ],
            'item_details' => $itemDetails,
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
        $url = 'https://api.sandbox.midtrans.com/v2/order-' . $id . '-' . $rent->created_at . '/status';

        $response = $client->request('GET', $url, [
            'headers' => [
              'accept' => 'application/json',
              'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            ],
          ]);

        // dd($response);
        $data = json_decode($response->getBody(), true);
        $statusCode = $data['status_code'];

        $itemDetails = [];
        foreach ($rent->rent_details as $detail) {
            $product = $detail->product; // Ambil produk terkait dari detail sewa
            if ($product) {
                $itemDetails[] = [
                    'id' => $product->id, // ID produk
                    'price' => intval(round($product->price)), // Harga produk
                    'quantity' => $detail->quantity, // Jumlah
                    'name' => $product->name, // Nama produk
                ];
            }
        }

        if($statusCode == 404){
            // Handle if transaction is not onPending

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => 'order-' . $rent->id . '-' . $rent->created_at,
                    'gross_amount' => $rent->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->firstname,
                    'last_name' => $request->user()->lastname,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                ],
                'item_details' => $itemDetails,
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

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => 'order-' . $rent->id . '-' . $rent->created_at,
                    'gross_amount' => $rent->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->firstname,
                    'last_name' => $request->user()->lastname,
                    'email' => $request->user()->email,
                    'phone' => $request->user()->phone,
                ],
                'item_details' => $itemDetails,
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
            return response()->json(['status' => 'error', 'message' => 'Transaction error.'], 400);
        }

        return response()->json(['status' => 'success', 'snapToken' => $rent->snap_token, 'url' => $url, 'response' => $data]);
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $reason = $request->input('reason');

        $client = new Client();

        $rent = Rent::findOrFail($id);

        $url = 'https://api.sandbox.midtrans.com/v2/order-' . $id . '-' . $rent->created_at . '/status';

        $response = $client->request('GET', $url, [
            'headers' => [
              'accept' => 'application/json',
              'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
            ],
        ]);

        // dd($response);
        $data = json_decode($response->getBody(), true);
        $statusCode = $data['status_code'];

        if($statusCode == 201){
            // Handle if transaction is not on pending
            $url = 'https://api.sandbox.midtrans.com/v2/order-' . $id . '-' . $rent->created_at . '/cancel';

            $response = $client->request('POST', $url, [
                'headers' => [
                  'accept' => 'application/json',
                  'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key')),
                ],
              ]);

            $data = json_decode($response->getBody(), true);
        }

        $rent = Rent::findOrFail($id);
        $rentDetails = RentDetailsModel::where('rent_id', $rent->id)->get();

        foreach ($rentDetails as $detail) {
            // Temukan produk berdasarkan product_id
            $product = Product::find($detail->product_id);
            if ($product) {
                // Kembalikan stok produk
                $product->stock += $detail->quantity; // Tambahkan kembali jumlah yang disewa
                $product->save(); // Simpan perubahan stok
            }
        }

        $rent->status_rent = 'cancelled';
        $rent->cancel_reason = $reason;
        $rent->save();

        return response()->json(['status' => 'success', 'message' => 'Order cancelled successfully.', 'data' => $data]);
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

    public function paymentSuccess(Request $request, $id)
    {
        $rent = Rent::findOrFail($id);
        $rent->payment_method = $request->payment_method;
        $rent->status_rent = 'process';
        $rent->save();

        return response()->json(['status' => 'success', 'message' => 'Payment success, order is being processed.']);
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
