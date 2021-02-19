<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class searchController extends Controller
{
    public function searchProducts(Request $request){
       
        $products = Product::where('name', 'LIKE', "%$request->search%")->orWhere('brand', 'LIKE', "%$request->search%")->where('quantity', '>', 0)->orderBy('id', 'desc')->paginate(24);

        //$brand = Product::select('brand', 'brand_id')->groupBy('brand', 'brand_id')->get();

        $brand = Product::select('brand')
        ->where('quantity', '>', 0)
        ->where('name', 'LIKE', "%$request->search%")
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();
        
        //dd(count($brand));
        return view('result',[
            'pro' => $products,
            'brands' => $brand,
            'search' => $request->search,
            'brandname' => ''
        ]);

    }
    
    public function searchProductsByBrand(Request $request){

        $search = mb_strtoupper(str_replace("-", " ",$request->searching)); 

        $brandName = mb_strtoupper(str_replace("-", " ",$request->brand));
       
        $products = Product::where('quantity', '>', 0)->where('name', 'LIKE', "%$search%")->Where('brand', $brandName)->orderBy('id', 'desc')->paginate(24);

        //$brand = Product::select('brand', 'brand_id')->groupBy('brand', 'brand_id')->get();
        $brand = Product::select('brand')
        ->where('quantity', '>', 0)
        ->where('name', 'LIKE', "%$search%")
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();

        return view('result',[
            'pro' => $products,
            'brands' => $brand,
            'search' => $search,
            'brandname' => $brandName,
        ]);

    }
}
