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

    public function set($request){

        $default = 0;

        if (isset($request->sameaddress)){
            $default = 1;
            $preview = Address::where('user_id', Auth::user()->id)->where('default', 1)->first();
            $preview->default = 0;
            $preview->save();
        }

        $this->user_id = Auth::user()->id;
        $this->address = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4;
        $this->country = $request->country;
        $this->dpt = $request->dpt;
        $this->city = $request->city;
        $this->zipcode = $request->zipcode;
        $this->phone = $request->phone;
        $this->contact = $request->contact;
        $this->details = $request->details;
        $this->default = $default;
        
        $rs = $this->save();

        return $rs;
    }
}
