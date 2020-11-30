<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Auth;

class Creditcard extends Model
{
    protected $table = 'creditcards';

    protected $fillable = [
        'user_id', 'fullname','cardnumber', 'expiration', 'cvv'
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
        $this->brand = $brandCard;
        $this->fullname = $request->cc_name;
        $this->cardnumber = $dataEncrypt;
        $this->last4num = $last4num;
        $this->expiration = $expiration_cc;
        $this->cvv = $request->cc_cvv;
        $this->default = 1;
        $this->save();
        
        $rs = $this->save();

        return $rs;
    }
}
