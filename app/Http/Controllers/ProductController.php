<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use App\Member;
use App\Creditcard;
use App\Address;
use App\WishList;
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
        $card = null;
        $address = null;

        if (Auth::user()){
            $id = Auth::user()->id;
            // $query = Member::select('members.email as email', 'members.firstname','members.lastname','members.address', 'members.delivery_address', 'members.city', 'members.dpt', 'members.country', 'members.n_doc', 'c.fullname','c.cardnumber', 'c.last4num', 'c.expiration', 'c.cvv')
            // ->join('creditcards as c', 'members.user_id', '=', 'c.user_id' )
            // ->where('members.user_id', $id)->get();

            //$card = Creditcard::where('user_id', $id)->where('default', 1)->get();
            $address = Address::where('user_id', $id)->where('default', 1)
            ->join('countries as c', 'c.country_master_id', 'addresses.country')
            ->join('departments as d', 'd.code', 'addresses.dpt')
            ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
            ->get();
            //dd($address);
            // (($card->count() >0) and ($address->count() >0))
            if ($address->count() >0){
                $answer = 1;
                //$member_info = $query;
            }

        }
        
        
        return view('cart', [
            'answer' => $answer,
            'member_info' => $member_info,
            // 'card' => $card,
            'address' => $address
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
                        "photo" => env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
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
            "photo" => env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
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
        $product = Product::select('products.id', 'products.reference', 'products.name', 'products.brand', 'products.subcategory_id', 'products.description', 'products.price', 'products.img1','products.prom', 'l.id as lot_id')
        ->leftJoin('lots as l', 'products.id', 'l.product_id')
        ->leftJoin('stocks as s', 's.lot_id', 'l.id')
        ->selectRaw('sum(s.quantity) as stockquantity, l.id as lot2')
        ->groupBy('l.id')
        ->groupBy('products.id')
        ->orderBy('products.id')
        ->where('products.id', $pro_id)
        ->first();



        $similar = Product::where('subcategory_id', '=',$product->subcategory_id)->where('id', '<>', $product->id)->paginate(12);
        
        return view('details',[
            'prod_id' => $pro_id,
            'prod_info' => $product,
            'similars' => $similar,
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupSon(Request $request){
        
        $Gfather = $request->gfather;
        $father = $request->father;
        $string = explode("_", $request->son);

        $subCategory_id = $string[1];
        $son = $string[0];

        $products = Product::where('subcategory_id', $subCategory_id)->orderBy('name')->paginate(24);
        $brand = Product::select('brand')->where('subcategory_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();

        
        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function addToWishList(Request $request){
        
        if (Auth::user()){
            $user_id = Auth::user()->id;
            $pro_id = $request->id;
        
            $product = Product::find($pro_id);
            if(!$product) {
                abort(404);
            }

            $info = WishList::where('user_id', $user_id)->where('product_id', $pro_id)->exists();
            if(!$info){
                $list = New WishList();
                $rs = $list->set($request);
    
                if($rs){
                    return redirect('cart')->with('success', 'Producto agregado a lista de deseos de manera Exitosa!!');
                }else{
                    return back()->with('notice', 'Un error ha ocurrido!!');
                }
            }else{

            }

        }
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupByBand(Request $request){
        $Gfather = $request->gfather;
        $father = $request->father;
        $string = explode("_", $request->son);

        $subCategory_id = $string[1];
        $son = $string[0];

        $brandName = mb_strtoupper(str_replace("-", " ",$request->brand)); 

        $products = Product::where('subcategory_id', $subCategory_id)->where('brand', $brandName)->orderBy('name')->paginate(24);
        $brand = Product::select('brand')->where('subcategory_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();

        
        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupGfa(Request $request){
        
        
        $string = explode("_", $request->gfather);

        $category_id = $string[1];
        $Gfather = $string[0];
        
        $products = Product::join('categories as c', 'c.id', '=', 'products.subcategory_id')
        ->join('categories as c2', 'c2.id', '=', 'c.father_id')
        ->join('categories as c3', 'c3.id', '=', 'c2.father_id')
        ->where('c3.id', $category_id)->orderBy('products.name')->paginate(24);

        
        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => '',
            'son' => '',
            'subcat_id' => 0,
            'products' => $products,
            'brands' => [],
        ]);
    }
}
