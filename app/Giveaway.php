<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giveaway extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'city'
    ];

    public function set($request){

        $this->name = $request->name;
        $this->email = $request->email;
        $this->city = $request->city;
        $this->phone = $request->phone;
        $rs = $this->save();

        return $rs;
    }
}
