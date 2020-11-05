<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use App\Member;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    
    public function cart()
    {
        $answer = 0;
        $member_info = null;

        if (Auth::user()){
            $id = Auth::user()->id;
            $query = DB::table('members as m')
            ->select('m.email as email', 'm.firstname','m.lastname','m.address', 'm.delivery_address', 'm.city', 'm.dpt', 'm.country', 'm.n_doc', 'c.fullname','c.cardnumber', 'c.expiration', 'c.cvv')
            ->join('creditcards as c', 'm.user_id', '=', 'c.user_id' )
            ->where('m.user_id', $id)->get();

            if ($query->count() >0){
                $answer = 1;
                $member_info = $query;
            }

        }
        

        return view('cart', [
            'answer' => $answer,
            'member_info' => $member_info
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function addToCart($id)
    {
        $product = Product::find($id);
 
        if(!$product) {
 
            abort(404);
 
        }
 
        $cart = session()->get('cart');
        
        $hash = md5(env('SECRETPASS')."~".$product->name."~".$product->price."~".$product->prom);

        // if cart is empty then this the first product
        if(!$cart) {
            
            

            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" =>  env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
                        "prom" => $product->prom,
                        "delivery_cost" => $product->delivery_cost,
                        "hash" => $hash
                    ]
            ];
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
 
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
 
            $cart[$id]['quantity']++;
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Product added to cart successfully!');
 
        }
 
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" =>  env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
            "prom" => $product->prom,
            "delivery_cost" => $product->delivery_cost,
            "hash" => $hash
        ];
 
        session()->put('cart', $cart);
 
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function addToCartQuantity(Request $request)
    {
        $id = $request->id;
        $cant = $request->quantity;
        
        $product = Product::find($id);
        
 
        if(!$product) {
 
            abort(404);
 
        }
 
        $cart = session()->get('cart');
        
        $hash = md5(env('SECRETPASS')."~".$product->name."~".$product->price."~".$product->prom);

        // if cart is empty then this the first product
        if(!$cart) {
            
            

            $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => $cant,
                        "price" => $product->price,
                        "photo" => $product->img1,
                        "prom" => $product->prom,
                        "delivery_cost" => $product->delivery_cost,
                        "hash" => $hash
                    ]
            ];
 
            session()->put('cart', $cart);
 
            return redirect('/product'.'/'.$id)->with('success', 'Usuario creado de manera Exitosa!!');
        }
 
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
 
            $cart[$id]['quantity'] += $cant;
 
            session()->put('cart', $cart);
 
            return redirect('/home')->with('success', 'Usuario creado de manera Exitosa!!');
 
        }
 
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => $cant,
            "price" => $product->price,
            "photo" => $product->img1,
            "prom" => $product->prom,
            "delivery_cost" => $product->delivery_cost,
            "hash" => $hash
        ];
 
        session()->put('cart', $cart);
 
        return redirect('/product'.'/'.$id)->with('success', 'Usuario creado de manera Exitosa!!');
        
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
             
            $cart[$request->id]["quantity"] = $request->quantity;
 
            session()->put('cart', $cart);
 
            session()->flash('success', 'Cart updated successfully');
        }
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------

 
    public function remove(Request $request)
    {
        if($request->id) {
 
            $cart = session()->get('cart');
 
            if(isset($cart[$request->id])) {
 
                unset($cart[$request->id]);
 
                session()->put('cart', $cart);
            }
 
            session()->flash('success', 'Product removed successfully');
        }
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function thanks(Request $request)
    {
        session()->forget('cart');

        return view('thanks');
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function details(Request $request)
    {
        $pro_id = $request->id;
        $product = Product::find($pro_id);

        return view('details',[
            'prod_id' => $pro_id,
            'prod_info' => $product
        ]);
    }

    public function groupSon(Request $request){
        $Gfather = $request->gfather;
        $father = $request->father;
        $string = explode("_", $request->son);

        $subCategory_id = $string[1];
        $son = $string[0];

        $products = Product::where('subcategory_id', $subCategory_id)->orderBy('name')->paginate(24);

        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'products' => $products
        ]);
    }
}
