<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $pickup;
    public $return;
    public $items;
    public $grandtotal;

    public function __construct($userName, $pickup, $return, $items, $grandtotal)
    {
        $this->userName = $userName;
        $this->pickup = $pickup;
        $this->return = $return;
        $this->items = $items;
        $this->grandtotal = $grandtotal;
    }

    public function build()
    {
        return $this->view('emails.invoice')
                    ->subject('Tagihan Pesanan Anda')
                    ->with([
                        'userName' => $this->userName,
                        'pickup' => $this->pickup,
                        'return' => $this->return,
                        'items' => $this->items,
                        'grandtotal' => $this->grandtotal,
                    ]);
    }
}

