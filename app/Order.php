<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Voucher;
use Auth;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'email', 'customer','payment', 'delivery_address', 'dpt', 'country', 'n_doc'
    ];

    public function insert($request, $method, $amount, $address){
        
        $voucher_id = 0;
        $voucher_type = 0;
        $delivery_cost = 0;
        $payment = "Pago";
        
        
        if (session()->get('deliveryCost')){
            if (session('deliveryCost') == "freeVoucher"){
                if (session()->get('voucher')){
                    $voucher_id = session('voucher')['voucher_id'];
                    $delivery_cost = session('voucher')['voucher_cost'];
                    $voucher_type = session('voucher')['voucher_type'];

                    $rv = app('App\Voucher')->updateVoucher($voucher_id);
                }
            }else if (session('deliveryCost') == "free"){
                $delivery_cost = 0;
            }else{
                if (session()->get('tcc')){
                    $delivery_cost = session('tcc')->consultarliquidacion2Result->total->totaldespacho;
                }
            }
        }
        else if (session()->get('tcc')){

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
        $this->voucher_id = $voucher_id;
        $this->type_voucher = $voucher_type;
        $this->delivery_cost = $delivery_cost;
        $this->discount_quantity = 0;

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

    public static function approval_order($order, $payment_type){
        $r = 0;
        
        $rs = Order::find($order);
        $rs->status = "Approved";
        $rs->status_after_approved = "Stock";
        $rs->payment = $payment_type;
        if ($rs->discount_quantity == 1){
            $r = 1;
        }else{
            $rs->discount_quantity = 1;
        }
        $rs->save();

        return array($r, $rs);
    }
    public static function approval_orderPayU($order, $request){

        $r = 0;

        $rs = Order::find($order);
        $rs->status = "Approved";
        $rs->method = 5;
        $rs->status_after_approved = "Stock";
        $rs->payment = $request['payment_method_name'];

        if ($rs->discount_quantity == 1){
            $r = 1;
        }else{
            $rs->discount_quantity = 1;
        }
        
        $rs->save();

        return array($r, $rs);
    }
}
