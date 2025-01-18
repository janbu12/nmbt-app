<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReadyPickupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public $date;

    public $items;

    public function __construct($userName, $date, $items)
    {
        $this->userName = $userName;
        $this->date = $date;
        $this->items = $items;
    }

    public function build()
    {
        return $this->view('emails.ready_pickup')
                    ->subject('Your Order Ready to Pickup')
                    ->with([
                        'userName' => $this->userName,
                        'date' => $this->date,
                        'items' => $this->items,
                    ]);
    }
}
