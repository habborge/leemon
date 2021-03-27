<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payu_payment extends Model
{
    protected $fillable = [
        'order_id', 'method', 'reference','signature', 'error'
    ];
}
