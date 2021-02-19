<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            $delivery_ad = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4;
            $details = $request->address_d;
            $coutry = $request->country;
            $dpt = $request->dpt;
            $city = $request->city;
            $zipcode = $request->zipcode;
            $contact = $request->firstname." ".$request->lastname;
        }else{
            $delivery_ad = $request->address_1b."~".$request->address_2b."~".$request->address_3b."~".$request->address_4b;
            $details = $request->address_db;
            $coutry = $request->country_e;
            $dpt = $request->dpt_e;
            $city = $request->city_e;
            $zipcode = $request->zipcode_e;
            $contact = $request->contact;
        }

        $newDate = date("Y-m-d", strtotime($request->birthday));
        //try{
        
            $this->user_id = Auth::user()->id;
            $this->firstname = $request->firstname;
            $this->lastname = $request->lastname;
            $this->birthday = $newDate;
            $this->phone = $request->phone;
            $this->email = Auth::user()->email;
            $this->address = $request->address_1." ".$request->address_2." ".$request->address_3." ".$request->address_4;
            $this->delivery_address = $delivery_ad;
            $this->country = $request->country;
            $this->dpt = $request->dpt;
            $this->city = $request->city;
            $this->n_doc = $request->n_doc;
            $this->status = 1;

            $rs = $this->save();

            $address_info = New Address();
            $address_info->user_id = Auth::user()->id;
            $address_info->address = $delivery_ad;
            $address_info->country = $coutry;
            $address_info->dpt = $dpt;
            $address_info->city = $city;
            $address_info->zipcode = $zipcode;
            $address_info->phone = $request->phone;
            $address_info->contact = $contact;
            $address_info->details = $details;
            $address_info->default = 1;
            $address_info->save();

        // }catch (\Exception $e) {
        //     //return $e->getMessage();
        //     if ($e->getCode() == 23000) { // numero del error para Duplicate entry '%s' for key %d
        //         $message = "La Información ya ah sido almacenada.";
        //         $t_message = 2;
        //     }
        // }
        return $rs;
    }


}
