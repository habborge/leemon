<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class searchController extends Controller
{
    public function searchProducts(Request $request){
       
        //$products = Product::where('quantity', '>', 0)->where('name', 'LIKE', "%$request->search%")->orWhere('brand', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(24);

        $products = Product::whereRaw("MATCH(name,brand) AGAINST(? IN BOOLEAN MODE)", array("\"$request->search \"")) 
        ->orderBy('quantity', 'DESC')
        ->paginate(24);

        //$brand = Product::select('brand', 'brand_id')->groupBy('brand', 'brand_id')->get();
        // if ((strlen($request->search) == "te") or (strlen($request->search) == "té") or (strlen($request->search) == "Te") or (strlen($request->search) == "Té") or (strlen($request->search) == "TE") or (strlen($request->search) == "TÉ")){
        //     $busqueda = "%$request->search%";
        // }else{
        //     $busqueda = "%$request->search%";
        // }

        $brand = Product::select('brand')
        ->where('quantity', '>', 0)
        ->where('name', 'LIKE', )
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
