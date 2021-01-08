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
        $this->order_id = $order_id;
        $this->product_id = $array['product_id'];
        $this->name = $array['name'];
        $this->description = "Descripción del producto";
        $this->quantity = $array['quantity'];
        $this->price = $array['price'];
        $this->img1 = $array['photo'];
        $this->prom = $array['prom'];
        $this->save();
       
        return true;
    }
}
