<?php

namespace App\Console\Commands;

use App\Models\ProductRentModel;
use App\Models\Rent;
use App\Models\RentDetailsModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelUnpaidOrders extends Command
{
    protected $signature = 'orders:cancel-unpaid';
    protected $description = 'Cancel unpaid orders that exceeded payment time limit and restore product stock';

    public function handle()
    {
        $expiredOrders = Rent::where('status_rent', 'unpaid')
            ->where('payment_expires_at', '<', Carbon::now())
            ->get();

        $cancelledCount = 0;

        foreach ($expiredOrders as $order) {
            // Ambil detail sewa (produk yang disewa)
            $rentDetails = RentDetailsModel::where('rent_id', $order->id)->get();

            // Kembalikan stok produk
            foreach ($rentDetails as $detail) {
                $product = ProductRentModel::find($detail->product_id);
                if ($product) {
                    $product->stock += $detail->quantity; // Tambahkan kembali stok
                    $product->save();
                }
            }

            // Ubah status pesanan menjadi cancelled
            $order->update(['status_rent' => 'cancelled']);

            $cancelledCount++;
        }

        $this->info("Cancelled $cancelledCount expired unpaid orders and restored stock.");
    }
}
