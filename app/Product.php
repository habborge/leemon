<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'reference', 'name', 'brand', 'description', 'quantity', 'measure', 'cost', 'price', 'price_min', 'img1', 'img2'
    ];
}
