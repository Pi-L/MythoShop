<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Order;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $addresse;
    public $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order = null)
    {
        $this->order = $order;
        $this->user = $order->user()->first();
        $this->addresse = $order->addresseShipping()->first();
        $this->products = $order->products()->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre Commande MythoShop est confirmée')->markdown('mail.orderConfirmed');
    }
}
