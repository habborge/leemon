<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Product;
use Auth;

class SendToFriend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product_id, $proName, $img, $member_name)
    {
        $this->product_id = $product_id;
        $this->proname = $proName;
        $this->img = $img;
        $this->member_name = $member_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mem_id = Auth::user()->id;

        $pro_url = env('APP_URL')."/product/".$this->product_id;
        
        return $this->markdown('emails.invitation')
        ->subject($this->member_name.' le recomienda este producto')
        ->with(['product_url' => $pro_url, 'product_name' => $this->proname, 'product_img' => $this->img ,'member_name' => $this->member_name]);
    }
}
