<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = [
        'batchcode', 'product_id','man_date', 'exp_date', 'quantity', 'cost'
    ];
}
