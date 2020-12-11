<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $fillable = [
        'order_id', 'name', 'description','quantity', 'price', 'img1', 'prom'
    ];

    public function insert($order_id, $array)
    {
        $i = 0;
        
        for ($i=0; $i < count($array); $i++ ){
            $this->order_id = $order_id;
            $this->product_id = $array[$i]['product_id'];
            $this->name = $array[$i]['name'];
            $this->description = "Descripción del producto";
            $this->quantity = $array[$i]['quantity'];
            $this->price = $array[$i]['price'];
            $this->img1 = $array[$i]['photo'];
            $this->prom = $array[$i]['prom'];
            $this->save();
        }

        return true;
    }
}
