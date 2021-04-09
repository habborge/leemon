<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifyAvailability extends Model
{
    protected $table = 'notify_availability';

    protected $fillable = [
        'product_id', 'email', 'sent'
    ];

    public function insert($product_id, $email){
        
        $this->product_id = $product_id;
        $this->email = $email;
        $this->sent = 0;
        $rs = $this->save();
    }
}
