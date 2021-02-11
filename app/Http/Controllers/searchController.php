<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class searchController extends Controller
{
    public function searchProducts(Request $request){
       
        $products = Product::where('quantity', '>', 0)->where('name', 'LIKE', "%$request->search%")->orWhere('brand', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(24);

        $brand = Product::select('brand')->groupBy('brand')->get();
        return view('result',[
            'search' => $products,
            'brands' => $brand,
        ]);

    }
}
