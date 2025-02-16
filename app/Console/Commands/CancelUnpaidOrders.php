<?php

namespace App\Console\Commands;

use App\Models\ProductRentModel as Product;
use App\Models\Rent;
use App\Models\RentDetailsModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelUnpaidOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Cancel unpaid orders that exceeded payment time limit';

    public function handle()
    {
        $expiredOrders = Rent::where('status_rent', 'unpaid')
            ->where('payment_expires_at', '<', Carbon::now())
            ->get();

        foreach ($expiredOrders as $order) {
            // Update status ke cancelled
            $order->status_rent = 'cancelled';
            $order->save();

            // Kembalikan stok produk
            foreach ($order->rentDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    $product->stock += $detail->quantity;
                    $product->save();
                }
            }
        }

        $this->info("Cancelled " . count($expiredOrders) . " expired unpaid orders.");
    }
}
