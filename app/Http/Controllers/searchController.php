<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class searchController extends Controller
{
    public function searchProducts(Request $request){
       
        $products = Product::where('name', 'LIKE', "%$request->search%")->orWhere('brand', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(20);
        return view('result',[
            'search' => $products 
        ]);

    }
}
