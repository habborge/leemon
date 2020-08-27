<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $order_id)
    {
        $this->customer = $customer;
        $this->order_id = $order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.orders')
        ->with(['customer' => $this->customer])
        ->attach(public_path('/orders'.'/order_'.$this->order_id.'.pdf'), [
            'as' => 'order_'.$this->order_id.'.pdf',
            'mime' => 'application/pdf',
        ])
        ->attach(public_path('/img'.'/'.$this->order_id.'.png'), [
            'as' => $this->order_id.'.png',
            'mime' => 'image/png',
        ]);
    }
}
