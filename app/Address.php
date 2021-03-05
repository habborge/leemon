<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id', 'address', 'country', 'city', 'dpt', 'zipcode', 'details'
    ];

    public function set($request, $info, $valueFrom){

        $default = 0;

        if ((isset($request->sameaddress)) or ($valueFrom == 1)){
            $default = 1;
            $preview = Address::where('user_id', Auth::user()->id)->where('default', 1)->first();
            $preview->default = 0;
            $preview->save();
        }

        // $delivery_ad = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4;
        // $details = $request->address_d;
        // $coutry = $request->country;
        // $dpt = $request->dpt;
        // $city = $request->city;
        // $obs= $request->obs;

        // $address_info = New Address();
        // $address_info->user_id = Auth::user()->id;
        // $address_info->address = $delivery_ad;
        // $address_info->country = $coutry;
        // $address_info->dpt = $dpt;
        // $address_info->phone = $info->phone;
        // $address_info->contact = $info->firstname." ".$info->lastname;
        // $address_info->city = $city;
        // $address_info->zipcode = $obs;
        // $address_info->details = $details;
        // $address_info->default = 1;
        // $address_info->save();

        $this->user_id = Auth::user()->id;
        $this->address = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4."-".$request->address_5;
        $this->country = $request->country;
        $this->dpt = $request->dpt;
        $this->city = $request->city;
        $this->zipcode = $request->obs;
        $this->phone = $request->phone;
        $this->contact = $info->firstname." ".$info->lastname;;
        $this->details = $request->address_d;
        $this->default = $default;
        
        $rs = $this->save();

        return $rs;
    }
}
