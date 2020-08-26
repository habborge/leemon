<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Creditcard;

class Member extends Model
{
    protected $fillable = [
        'user_id', 'email', 'firstname','lastname','address', 'delivery_address', 'city', 'dpt', 'country', 'n_doc'
    ];

    public function set($request){

        if ($request->delivery_address == ""){
            $delivery_ad = $request->address;
        }else{
            $delivery_ad = $request->delivery_address;
        }

        $this->user_id = Auth::user()->id;
        $this->firstname = $request->firstname;
        $this->lastname = $request->lastname;
        $this->email = $request->email;
        $this->address = $request->address;
        $this->delivery_Address = $delivery_ad;
        $this->country = $request->country;
        $this->dpt = $request->dpt;
        $this->city = $request->city;
        $this->n_doc = $request->n_doc;
        $rs = $this->save();

        $card_info = New Creditcard();
        $card_info->user_id = Auth::user()->id;
        $card_info->fullname = $request->cc_name;
        $card_info->cardnumber = $request->cc_number;
        $card_info->expiration = $request->cc_expiration;
        $card_info->cvv = $request->cc_cvv;
        $card_info->save();
        
        return $rs;
    }


}
