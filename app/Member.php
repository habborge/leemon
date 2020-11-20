<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Auth;
use App\Creditcard;
use App\Address;

class Member extends Model
{
    protected $fillable = [
        'user_id', 'email', 'firstname','lastname','address', 'delivery_address', 'city', 'dpt', 'country', 'n_doc'
    ];

    public function set($request){

        if (isset($request->sameaddress)){
            $delivery_ad = $request->address_1." ".$request->address_2." ".$request->address_3." ".$request->address_4;
            $details = $request->address_d;
            $coutry = $request->country;
            $dpt = $request->dpt;
            $city = $request->city;
            $zipcode = $request->zipcode;
        }else{
            $delivery_ad = $request->address_1b." ".$request->address_2b." ".$request->address_3b." ".$request->address_4b;
            $details = $request->address_db;
            $coutry = $request->country_e;
            $dpt = $request->dpt_e;
            $city = $request->city_e;
            $zipcode = $request->zipcode_e;
        }

        $key = hash( config('app.encryption'), md5(Auth::user()->id."~".Auth::user()->email));
        $iv = substr( hash( env('APP_SERIAL'), md5(Auth::user()->id."~".Auth::user()->email)), 0, 16 );
        $dataEncrypt = base64_encode( openssl_encrypt( $string, config('app.cipher'), $key, 0, $iv ) );

        dd($dataEncrypt);
        
        $this->user_id = Auth::user()->id;
        $this->firstname = $request->firstname;
        $this->lastname = $request->lastname;
        $this->email = Auth::user()->email;
        $this->address = $request->address;
        $this->delivery_address = $delivery_ad;
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

        $address_info = New Address();
        $address_info->user_id = Auth::user()->id;
        $address_info->address = $delivery_ad;
        $address_info->country = $coutry;
        $address_info->dpt = $dpt;
        $address_info->city = $city;
        $address_info->zipcode = $zipcode;
        $address_info->phone = '';
        $address_info->contact = '';
        $address_info->detais = $details;

        return $rs;
    }


}
