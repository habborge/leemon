<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class searchController extends Controller
{
    public function searchProducts(Request $request){
       
        // $products = Product::where('quantity', '>', 0)
        // ->where('name', '=', "$request->search")
        // ->orWhere('name', 'LIKE', "%$request->search%")
        // ->orWhere('brand', 'LIKE', "%$request->search%")
        // ->orderByRaw("FIELD(name, 'vitamina d')", 'asc')
        // ->paginate(24);

        $products = Product::where('name', '=', "$request->search")
        ->orWhere('name', 'LIKE', "%$request->search%")
        ->orWhere('brand', 'LIKE', "%$request->search%")
        ->orderByRaw("CASE WHEN name = '".$request->search."' THEN 10
        WHEN name LIKE '".$request->search."%' THEN 8
        WHEN name LIKE '%".$request->search."%' THEN 6
        WHEN brand LIKE '%".$request->search."%' THEN 4
        END DESC")
        ->orderBy('name', 'asc')
        ->orderBy('quantity', 'desc')
        ->paginate(24);

        
        // $products = Product::selectRaw("0 AS score,(CASE WHEN name = '".$request->search."' THEN score + 10
        // WHEN name LIKE '".$request->search."%' THEN score + 8
        // WHEN name LIKE '%".$request->search."%' THEN score + 6
        // WHEN brand LIKE '%".$request->search."%' THEN score + 4
        // END) AS score")
        // ->orderBy('score', 'DESC')
        // ->paginate(24);

        // $products = Product::selectRaw("0 AS score,(CASE WHEN name = '".$request->search."' THEN score + 10
        // WHEN name LIKE '".$request->search."%' THEN score + 8
        // WHEN name LIKE '%".$request->search."%' THEN score + 6
        // WHEN brand LIKE '%".$request->search."%' THEN score + 4
        // END) AS score")
        // ->orderBy('score', 'DESC')
        // ->paginate(24);

        // $products = Product::selectRaw("*,(MATCH(name, brand) AGAINST ('\"".$request->search."\"' IN BOOLEAN MODE) * 10) as relevance, (MATCH(name, brand) AGAINST ('".$request->search."' IN BOOLEAN MODE) * 1.5) As relevance2") 
        // ->whereRaw("MATCH(name,brand) AGAINST(? IN BOOLEAN MODE) > 0", array("\"$request->search \"")) 
        // ->orWhereRaw("MATCH(name,brand) AGAINST(? IN BOOLEAN MODE) > 0", array("$request->search"))
        
        // ->orderBy('relevance', 'DESC')
        // ->orderBy('relevance2', 'DESC')
        // ->paginate(24);

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
