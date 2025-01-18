<?php

namespace App\Mail;

use App\Models\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rent;
    public $status;

    public function __construct(Rent $rent, $status)
    {
        $this->rent = $rent;
        $this->status = $status;
    }

    public function build()
    {
        return $this->view('emails.rent_status_update')
                    ->subject('Update Status Sewa')
                    ->with([
                        'fullName' => $this->rent->user ? $this->rent->user->firstname . ' ' . $this->rent->user->lastname : 'Guest',
                        'rent' => $this->rent,
                        'status' => $this->status,
                    ]);
    }
}
