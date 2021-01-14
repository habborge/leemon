<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'email', 'customer','payment', 'delivery_address', 'dpt', 'country', 'n_doc'
    ];

    public function insert($request, $method, $amount, $address){
        
        if ($method == 1){
            $payment = "Nombre en la tarjeta: ".$request->fullname." - ".$request->brand." Credit Card terminada en **********".$request->last4num;
        }else {
            $payment = "Pago PSE";
        }
        
        
        $this->user_id = Auth::user()->id;
        $this->code_hash = session('codehash');
        $this->customer = $request->firstname." ".$request->lastname;
        $this->method = $method;
        $this->payment = $payment;
        $this->amount = $amount;
        $this->email = $request->email;
        $this->delivery_address = "Dirección: ".$address->address.", OBS:".$address->details.", Contacto:".$address->contact;
        $this->country = $address->country_master_name;
        $this->dpt = $address->department;
        $this->city = $address->city_d_id;
        
        $rs = $this->save();
        $id = $this->id;
       
        return array($rs, $id);
    }

    public static function pending_order($order){
        $rs = Order::find($order);
        $rs->status = "Processing";
        $rs->save();

        return $rs;
    }

    public static function reject_order($order){
        $rs = Order::find($order);
        $rs->status = "Reject";
        $rs->save();

        return $rs;
    }

    public static function approval_order($order){
        $rs = Order::find($order);
        $rs->status = "Approved";
        $rs->status_after_approved = "Stock";
        $rs->save();

        return $rs;
    }
}
