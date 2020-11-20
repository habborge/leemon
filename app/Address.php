<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id', 'address', 'country', 'city', 'dpt', 'zipcode', 'details'
    ];
}
