<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class WishList extends Model
{
    protected $table = "wishlists";
    protected $fillable = [
        'user_id', 'product_id'
    ];

    public function set($request){
        try{
            $this->user_id = Auth::user()->id;
            $this->product_id = $request->id;

            $rs = $this->save();
            return $rs;
            
        }catch(Exception $e){
            return redirect()->back()->withErrors(["error" => "Error: no se pudo almacenar la dirección"]);
        }
    }
}
