<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditcard extends Model
{
    protected $table = 'creditcards';

    protected $fillable = [
        'user_id', 'fullname','cardnumber', 'expiration', 'cvv'
    ];
}
