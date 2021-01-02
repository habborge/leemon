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
        $products_1 = Product::select('products.id', 'products.reference', 'products.name', 'products.brand', 'products.subcategory_id', 'products.description', 'products.price', 'products.img1','products.prom', 'l.id as lot_id')
        ->leftJoin('lots as l', 'products.id', 'l.product_id')
        ->leftJoin('stocks as s', 's.lot_id', 'l.id')
        ->selectRaw('sum(s.quantity) as stockquantity, l.id as lot2')
        ->groupBy('l.id')
        ->groupBy('products.id')
        ->orderBy('products.id')
        ->where('prom', '4')
        ->paginate(10);
        
        $prom_1 = "Productos Destacados";

        // $pros = Product::all();
        
        // foreach ($pros as $pro) {
        //     $price = 0;
        //     if ($pro->price == 0){
        //         $pre = random_int(10000, 99900);
        //     }else{
        //         $pre = $pro->price;
        //     }
        //     $price = round($pre/100.0,0)*100;

        //     $pro->price = $price;
        //     $pro->save();
        // }

        // $products_2 = Product::where('prom', '2')->orderBy('id')->paginate(12);
        // $prom_2 = "Paga el 2do con el 50% Off";

        return view('home',[
            'products_1' => $products_1,
            'prom_1' => $prom_1,
            // 'products_2' => $products_2,
            // 'prom_2' => $prom_2,
           /* 'name' => $products->name, 
            'brand' => $products->brand, 
            'description' => $products->description, 
            'quantity' => $products->quantity, 
            'measure' => $products->measure, 
            'price' => $products->price*/
        ]);
    }


}
