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
        $products = Product::paginate(20);

        return view('home',[
            'products' => $products 
           /* 'name' => $products->name, 
            'brand' => $products->brand, 
            'description' => $products->description, 
            'quantity' => $products->quantity, 
            'measure' => $products->measure, 
            'price' => $products->price*/
        ]);
    }
}
