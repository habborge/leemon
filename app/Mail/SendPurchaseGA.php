<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Product;
use App\Order_detail;

use Auth;

class SendPurchaseGA extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $member)
    {
        $this->order = $order;
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$mem_id = Auth::user()->id;

        //$pro_url = env('APP_URL')."/product/".$this->product_id;
        $order_details = Order_detail::select('order_details.order_id as orderID', 'order_details.product_id as proId', 'p.name as proName', 'order_details.quantity as cantidad', 'order_details.img1 as picture', 'order_details.price as proPrice', 'p.brand')
        ->join('products as p', 'p.id', 'order_details.product_id')
        ->where('order_id', $this->order['id'])->get();

        return $this->markdown('emails.purchaseGA')
        ->from(env('MAIL_FROM_ADDRESS'))
        ->subject('Compra en Leemon GA')
        ->with(['order' => $this->order, 'member' => $this->member, 'order_details' => $order_details]);
    }
}
