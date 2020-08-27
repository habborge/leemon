<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'email', 'customer','payment', 'delivery_address', 'dpt', 'country', 'n_doc'
    ];

    public function insert($request){
        $number = substr($request->cardnumber, -4, 4);

        $this->user_id = Auth::user()->id;
        $this->customer = $request->firstname." ".$request->lastname;
        $this->payment = "Credit Card No **********".$number;
        $this->email = $request->email;
        $this->delivery_address = $request->delivery_address;
        $this->country = $request->country;
        $this->dpt = $request->dpt;
        $this->city = $request->city;
        
        $rs = $this->save();
        $id = $this->id;
       
        return array($rs, $id);
    }
}
