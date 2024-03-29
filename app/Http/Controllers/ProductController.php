<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Product;
use Auth;
use App\Member;
use App\Creditcard;
use App\Address;
use App\WishList;
use App\Category;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3MultiRegionClient;
use Illuminate\Support\Facades\Http;

use Image;

class ProductController extends Controller
{
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------

    private function quickRandom()
    {
        $length = 16;
        $dt = new DateTime();
        $date = $dt->format('Y-m-d H:i:s');
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length)."~".$date;
    }
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    
    public function cart()
    {

        if(Auth::user()){
            $emailVerified = Auth::user()->email_verified;

            if($emailVerified == 0){
                return redirect('/register/auth/email/verify');
            }

            $address = Address::where('user_id', Auth::user()->id);
            if($address->doesntExist()){
                return redirect('/secure/delivery/address/verify');
            }else{
                
            }
        }
        

        if (session('cart')){
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
        }else{
            return redirect('/home');
        }
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
        
        $hash = md5(env('SECRETPASS')."~".$product->name."~".$product->price."~".$product->prom."~".$product->fee."~".$product->width."~".$product->height."~".$product->length."~".$product->weight);

        // $vol = $product->width."~".$product->height."~".$product->length."~".$product->weight;
        
        // if cart is empty then this the first product
        if(!$cart) {
            
            $str_code = $this->quickRandom();
            $code_hash = hash('ripemd160', $str_code);

            session()->put('codehash', $code_hash);

            $cart = [
                    $id => [
                        "product_id" => $id,
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "fee" => $product->fee,
                        "photo" =>  env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
                        "prom" => $product->prom,
                        "width" => $product->width,
                        "length" => $product->length,
                        "height" => $product->height,
                        "weight" => $product->weight,
                        "maxqua" => $product->quantity,
                        "hash" => $hash,
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
            "product_id" => $id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "fee" => $product->fee,
            "photo" =>  env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
            "prom" => $product->prom,
            "width" => $product->width,
            "length" => $product->length,
            "height" => $product->height,
            "weight" => $product->weight,
            "maxqua" => $product->quantity,
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
        
        $hash = md5(env('SECRETPASS')."~".$product->name."~".$product->price."~".$product->prom."~".$product->fee."~".$product->width."~".$product->height."~".$product->length."~".$product->weight);

        $vol = $product->width."~".$product->height."~".$product->length."~".$product->weight;

        // if cart is empty then this the first product
        if(!$cart) {
            
            if ($cant <= $product->quantity){
                $str_code = $this->quickRandom();
                $code_hash = hash('ripemd160', $str_code);

                session()->put('codehash', $code_hash);

                $cart = [
                        $id => [
                            "product_id" => $id,
                            "name" => $product->name,
                            "quantity" => $cant,
                            "price" => $product->price,
                            "fee" => $product->fee,
                            "photo" => env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
                            "prom" => $product->prom,
                            "width" => $product->width,
                            "length" => $product->length,
                            "height" => $product->height,
                            "weight" => $product->weight,
                            "maxqua" => $product->quantity,
                            "hash" => $hash
                        ]
                ];
    
                session()->put('cart', $cart);
    
                //return redirect('/product'.'/'.$id)->with('success', 'Producto adicionado de manera Exitosa!!');
                return response()->json(['status'=>200,'info' => 'Producto adicionado de manera Exitosa!!']);
            }else{
                return response()->json(['status'=>500,'info' => 'No puede adicionar una cantidad mayor a la existente en Stock']);
                
            }
            
        }
 
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            if (($cant + $cart[$id]['quantity'])<= $product->quantity){
 
                $cart[$id]['quantity'] += $cant;
 
                session()->put('cart', $cart);
 
                //return redirect('/home')->with('success', 'Usuario creado de manera Exitosa!!');
                return response()->json(['status'=>200,'info' => 'Producto adicionado de manera Exitosa!!']);
            }else{
                return response()->json(['status'=>500,'info' => 'No puede adicionar una cantidad mayor a la existente en Stock']);
            }
        }
 
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $id,
            "name" => $product->name,
            "quantity" => $cant,
            "price" => $product->price,
            "fee" => $product->fee,
            "photo" => env('AWS_URL')."/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/".$product->img1,
            "prom" => $product->prom,
            "width" => $product->width,
            "length" => $product->length,
            "height" => $product->height,
            "weight" => $product->weight,
            "maxqua" => $product->quantity,
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
        $product = Product::select('products.id', 'products.reference', 'products.name', 'products.brand', 'products.subcategory_id', 'products.description', 'products.characteristics', 'products.quantity as webquantity', 'products.ingredients','products.use','products.price', 'products.img1','products.prom', 'l.id as lot_id')
        ->leftJoin('lots as l', 'products.id', 'l.product_id')
        ->leftJoin('stocks as s', 's.lot_id', 'l.id')
        ->selectRaw('sum(s.quantity) as stockquantity, l.id as lot2')
        ->groupBy('l.id')
        ->groupBy('products.id')
        ->orderBy('products.id')
        ->where('products.id', $pro_id)
        ->first();

        $categories = Category::select('categories.id as catId', 'categories.name as catName', 'cf.name as fName', 'cgf.name as gfName' )
        ->join('product_categories as pc', 'categories.id', 'pc.category_id')
        ->leftJoin('categories as cf', 'cf.id', 'categories.father_id')
        ->leftJoin('categories as cgf', 'cgf.id', 'cf.father_id')
        ->where('pc.product_id', $pro_id)
        ->get();

        //dd($categories);

        //$similar = Product::where('subcategory_id', '=',$product->subcategory_id)->where('id', '<>', $product->id)->paginate(12);
        $similar = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        ->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', '=',$product->subcategory_id)
        ->where('products.id', '<>', $product->id)
        ->paginate(12);

        $url = env('BUCKET_SUBFOLDER')."/products/".$product->reference."/";
        //dd($url);
        $disk = Storage::disk('s3');
        $images = $disk->files($url);
        
        $key_a = array_search($url.$product->img1, $images);
        unset($images[$key_a]);
        
        //dd($images);
        return view('details',[
            'prod_id' => $pro_id,
            'prod_info' => $product,
            'similars' => $similar,
            'categories' => $categories,
            'images' => $images
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

        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        
        ->where('pc.category_id', $subCategory_id)
        ->orderBy('products.restrictions', 'DESC')
        ->orderBy('name')
        ->paginate(16);

        $brand = Product::select('brand')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        
        ->where('pc.category_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();

        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
            'brandname' => '',
            'orderPrice' => ''
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

        //$products = Product::where('subcategory_id', $subCategory_id)->where('brand', $brandName)->orderBy('name')->paginate(24);
        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->where('brand', $brandName)
        ->orderBy('products.restrictions', 'DESC')
        ->orderBy('name')
        ->paginate(24);

        $brand = Product::select('brand')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();
                
        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
            'brandname' => $brandName,
            'orderPrice' => '',
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
            'brandname' => '',
            'orderPrice' => ''
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupCategory(Request $request){
        $id = $request->id;

        if ($request->price){
            $orderName = 'products.price';
            if ($request->price == "lowtohigh"){
                $orderby = "ASC";
            }else{
                $orderby = "DESC";
            }
            $orderPosition = $request->price;
        }else{
            $orderName = 'products.img2';
            $orderby = "DESC";
            $orderPosition = "";
        }
        

        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.img2','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', '=', 'pc.product_id')
        ->join('categories as c', 'c.id', '=', 'pc.category_id')
        ->join('categories as c2', 'c2.id', '=', 'c.father_id')
        ->join('categories as c3', 'c3.id', '=', 'c2.father_id')
        ->where('c3.id', $id)
        ->where('price', '>', 0)
        ->groupBy('products.id')
        ->orderBy($orderName, $orderby)
        ->orderBy('products.name')
        ->paginate(24);

        //dd($products);
        $subcategories = Category::where('father_id', $id)->get();

        return view('products.categoryFather', [
            'gfather_id' => $request->id,
            'gfather' => str_replace("-", " ", $request->category),
            'father' => '',
            'son' => '',
            'subcategories' => $subcategories,
            'products' => $products,
            'brands' => [],
            'orderPrice' => $orderPosition
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupSubCategory(Request $request){
        
        $id = $request->id;
        $sub_id = $request->subid;

        if ($request->price){
            $orderName = 'products.price';
            if ($request->price == "lowtohigh"){
                $orderby = "ASC";
            }else{
                $orderby = "DESC";
            }
            $orderPosition = $request->price;
        }else{
            $orderName = 'products.img2';
            $orderby = "DESC";
            $orderPosition = "";
        }

        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', '=', 'pc.product_id')
        ->join('categories as c', 'c.id', '=', 'pc.category_id')
        ->join('categories as c2', 'c2.id', '=', 'c.father_id')
        ->groupBy('products.id')
        ->where('c2.id', $sub_id)
        ->where('price', '>', 0)
        ->orderBy($orderName, $orderby)
        ->paginate(24);

        //dd($products);
        $subcategories = Category::where('father_id', $sub_id)->get();

        return view('products.categorySon', [
            'gfather_id' => $request->id,
            'gfather' => str_replace("-", " ", $request->category),
            'father_id' => $sub_id,
            'father' => $request->subcategory,
            'son' => '',
            'subcategories' => $subcategories,
            'products' => $products,
            'brands' => [],
            'orderPrice' => $orderPosition
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupPrice(Request $request){

        $Gfather = $request->gfather;
        $father = $request->father;
        $string = explode("_", $request->son);

        $subCategory_id = $string[1];
        $son = $string[0];
        if ($request->price == "lowtohigh"){
            $orderPrice = "ASC";
        }else{
            $orderPrice = "DESC";
        }

        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->orderBy('products.price', $orderPrice)
        ->orderBy('name')
        ->paginate(16);

        $brand = Product::select('brand')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();

        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
            'brandname' => '',
            'orderPrice' => $request->price
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function groupByBandPrice(Request $request){
        $Gfather = $request->gfather;
        $father = $request->father;
        $string = explode("_", $request->son);

        $subCategory_id = $string[1];
        $son = $string[0];

        $brandName = mb_strtoupper(str_replace("-", " ",$request->brand)); 

        if ($request->price == "lowtohigh"){
            $orderPrice = "ASC";
        }else{
            $orderPrice = "DESC";
        }

        //$products = Product::where('subcategory_id', $subCategory_id)->where('brand', $brandName)->orderBy('name')->paginate(24);
        $products = Product::select('products.id as proId', 'products.reference','products.name as proName','products.brand','products.description','products.price','products.img1','products.prom','products.quantity as webquantity','products.health_register','products.width','products.length','products.height','products.weight','products.fee')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->where('brand', $brandName)
        ->orderBy('products.price', $orderPrice)
        ->orderBy('name')
        ->paginate(24);

        $brand = Product::select('brand')
        ->join('product_categories as pc', 'products.id', 'pc.product_id')
        //->join('lots as l', 'products.id', 'l.product_id')
        ->where('pc.category_id', $subCategory_id)
        ->groupBy('brand')
        ->selectRaw('count(brand) as total_brand, brand')->get();
                
        return view('products.categories', [
            'gfather' => str_replace("-", " ", $Gfather),
            'father' => str_replace("-", " ", $father),
            'son' => str_replace("-", " ", $son),
            'subcat_id' => $subCategory_id,
            'products' => $products,
            'brands' => $brand,
            'brandname' => $brandName,
            'orderPrice' => $request->price,
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function resize(){
        $brand = "MOD";
        $products = Product::where('brand', $brand)->get();

        $disk = Storage::disk('s3');
        foreach ($products as $product) {

            $imgname = $product->img1;
            $path = "/".env('BUCKET_SUBFOLDER')."/products/".$product->reference."/";
            //dd(env('AWS_URL').$path.$img);
            
               
            //Ruta donde queremos guardar las imagenes
            $path3 = $path.'/thumbnails/';

            //Creamos una instancia de la libreria instalada  
            $img = Image::make(env('AWS_URL').$path.$imgname);
            
            $img->resize(200, 200);
            $img->save( $disk->put($path3.$imgname, 'public'));

           

             
   

        }
    }
}
