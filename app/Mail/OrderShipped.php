<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Auth;

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
        $mem_id = Auth::user()->id;

        return $this->markdown('emails.orders')
        ->with(['customer' => $this->customer])
        ->attach(public_path('/orders'.'/order_'.$this->order_id.'.pdf'), [
            'as' => 'order_'.$this->order_id.'.pdf',
            'mime' => 'application/pdf',
        ])
        ->attach(public_path('/orders'.'/member_'.$mem_id.'.txt'), [
            'as' => 'member_'.$mem_id.'.txt',
            'mime' => 'text/plain',
        ]);
    }
}
