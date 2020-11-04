<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products_1 = Product::where('prom', '1')->orderBy('id')->paginate(10);
        $prom_1 = "Promo Paga 2 Lleva 3";

        $products_2 = Product::where('prom', '2')->orderBy('id')->paginate(4);
        $prom_2 = "Paga el 2do con el 50% Off";
        return view('home',[
            'products_1' => $products_1,
            'prom_1' => $prom_1,
            'products_2' => $products_2,
            'prom_2' => $prom_2,
           /* 'name' => $products->name, 
            'brand' => $products->brand, 
            'description' => $products->description, 
            'quantity' => $products->quantity, 
            'measure' => $products->measure, 
            'price' => $products->price*/
        ]);
    }
}
