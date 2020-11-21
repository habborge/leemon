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

    private function validateCardBrand($card){
        
        $last = substr($card, -4);

        if (substr($card, 0, 1) == 4){
            $brand = "Visa";
        }else if ((substr($card, 0, 2) == 51) or (substr($card, 0, 2) == 55)){
            $brand = "MasterCard";
        }else if (((substr($card, 0, 4) == 6011) and (strlen($card) == 16)) or ((substr($card, 0, 1) == 5) and (strlen($card) == 15))) {
            $brand = "Discover";
        }else if ((substr($card, 0, 2) == 34) or (substr($card, 0, 2) == 37)){
            $brand = "American Express";
        } 

        return array($brand, $last);
        
    }

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

        $Tcard = str_replace(" ", "", $request->cc_number);

        $key = Hash::make( config('app.encryption')."~".md5(Auth::user()->id."~".Auth::user()->email));
        $iv = substr( Hash::make( env('APP_SERIAL')."~".md5(Auth::user()->id."~".Auth::user()->email)), 0, 16 );
        $dataEncrypt = base64_encode( openssl_encrypt( $request->cc_number, config('app.cipher'), $key, 0, $iv ) );

        //$dataDecrypt = openssl_decrypt(base64_decode($dataEncrypt), config('app.cipher'), $key, 0, $iv );

        $dataCard = $this->validateCardBrand($Tcard);

        $last4num = $dataCard[1];
        $brandCard = $dataCard[0];

        $expiration_cc = $request->cc_expiration_m."/".$request->cc_expiration_y;
        
        $this->user_id = Auth::user()->id;
        $this->firstname = $request->firstname;
        $this->lastname = $request->lastname;
        $this->email = Auth::user()->email;
        $this->address = $request->address_1." ".$request->address_2." ".$request->address_3." ".$request->address_4;
        $this->delivery_address = $delivery_ad;
        $this->country = $request->country;
        $this->dpt = $request->dpt;
        $this->city = $request->city;
        $this->n_doc = $request->n_doc;
        $this->status = 1;

        $rs = $this->save();

        $card_info = New Creditcard();
        $card_info->user_id = Auth::user()->id;
        $card_info->brand = $brandCard;
        $card_info->fullname = $request->cc_name;
        $card_info->cardnumber = $dataEncrypt;
        $card_info->last4num = $last4num;
        $card_info->expiration = $expiration_cc;
        $card_info->cvv = $request->cc_cvv;
        $card_info->default = 1;
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
        $address_info->details = $details;
        $address_info->default = 1;
        $address_info->save();

        return $rs;
    }


}
