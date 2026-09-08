<?php

namespace App\Mail;

use App\Models\CustomerOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(CustomerOrder $order)
    {
        $this->order = $order;
    }

   public function build()
{
    return $this->subject('Order Placed Successfully - Imran Cloth House')
        ->view('emails.order-placed')
        ->with([
            'order' => $this->order,
        ]);
}
}