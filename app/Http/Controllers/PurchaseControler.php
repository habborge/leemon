<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Creditcard;
use App\Http\Requests\StoreMembers;
use Image;
use Illuminate\Support\Facades\DB;
use App\Address;
use App\Order;
use App\Order_detail;
use PDF;
use Mail;
use App\Mail\OrderShipped;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use SoapClient;
use App\Department;
use DateTime;
use App\Voucher;

class PurchaseControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function verifyInsert($request){
        
        $rules = [
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
            
            'city'  => 'required', 
            'dpt' => 'required',  
            'country' => 'required',  
        ];

        // if (!isset($request->sameaddress)){
            
        //     $rules['contact'] = 'required';
        //     $rules['address_1b'] = 'required';
        //     $rules['address_2b'] = 'required';
        //     $rules['address_3b'] = 'required';
        //     $rules['address_4b'] = 'required';
        //     $rules['city_e'] = 'required';
        //     $rules['dpt_e'] = 'required'; 
        //     $rules['country_e'] = 'required'; 
        // }
        
        return $p = Validator::make($request->all(), $rules);
    }

    //--------------------------------------------------------------------------------------------------------------    
    // Verify auth , then allow to register billing information
    //--------------------------------------------------------------------------------------------------------------
    public function verifyAddress(){

        $userEmail = Auth::user()->email;
        $emailVerified = Auth::user()->email_verified;
        $emailSendAt = Auth::user()->email_send_at;
            
            
        if($emailVerified == 0){
            return redirect('/register/auth/email/verify');
        }else{
            $infosaved = 0;
            $id = Auth::user()->id;
       
            $info = Address::where('user_id', $id);

            if ($info->exists()){
                $infosaved = 1;
            }

            $country_id = 47;
            $dpts = Department::where('country_id', $country_id)->orderBy('department', 'ASC')->get();

            return view('purchase', [
                'infosaved' => $infosaved,
                //'info' => $info->get(),
                'dpts' => $dpts
            ]);
        }
    }

    //--------------------------------------------------------------------------------------------------------------
    // Save costumer Information in members table and addresses table
    //--------------------------------------------------------------------------------------------------------------
        public function addInfoUser(Request $request){
            
            //dd($request);
            $infosaved = 0;
            $id = Auth::user()->id;

            // call function that check form inputs data
            $p = $this->verifyInsert($request);
            
            $info = Member::where('user_id', $id)->first();
    
            if ($p->fails()){
                // return view('purchase', [
                //     'completeRequest' => $request,
                //     'infosaved' => $infosaved,
                //     'info' => $info,
                //     // 'checkbox' => $request->sameaddress
                // ])->withErrors($p);
                return redirect()->back()->withInput()->withErrors($p);
            }else{
                
                //$res = $this->luhnCheck($request->cc_number);
                
                // $user_info = New Member();
                // $rs = $user_info->set($request);
                
                if($info){
                    $infosaved = 1;
                    $delivery_ad = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4."-".$request->address_5;
                    $details = $request->address_d;
                    $coutry = $request->country;
                    $dpt = $request->dpt;
                    $city = $request->city;
                    $obs= $request->obs;

                    $address_info = New Address();
                    $address_info->user_id = Auth::user()->id;
                    $address_info->address = $delivery_ad;
                    $address_info->country = $coutry;
                    $address_info->dpt = $dpt;
                    $address_info->phone = $info->phone;
                    $address_info->contact = $info->firstname." ".$info->lastname;
                    $address_info->city = $city;
                    $address_info->zipcode = $obs;
                    $address_info->details = $details;
                    $address_info->default = 1;
                    $address_info->save();

                    
                    return redirect('methods')->with('success', 'Dirección Agregada de amnera exitosa!!');

                }else{
                    //return back()->with('notice', 'Un error ha ocurrido!!');

                    $error = ['notice' => 'No se pudo procesar la información!!'];
                    return redirect()->back()->withInput()->withErrors($error);
                    // return view('purchase', [
                    //     'completeRequest' => $request,
                    //     'infosaved' => $infosaved,
                    //     'info' => $info,
                    //     //'checkbox' => $request->sameaddress,
                        
                    // ])->withErrors($error);    
                }
            }
           
        }

        
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function confirm()
    {
        // $valor_almacenado = session('cart');
        // dd($valor_almacenado);
        return view('confirm');
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function methods()
    {
        $currency = "COP";
        $method = 0;

        if ((Auth::user()) and (session('cart'))){

            if (session('myorder')){
                $orderid = session()->get('myorder');
                $orderInfo = Order::find($orderid);

                if (($orderInfo->status == "Approved") or ($orderInfo->status == "Processing")){
                    session()->forget(['cart', 'myorder', 'codehash']);
                    return redirect()->route('home');
                }
            }
            
            $answer = 1;
            $cardExist = 0;
            $member_info = null;
            $card = null;
            $address = null;
            $weight = 0;
            $volweight = 0;
            $sw = 0;
            $totalprice = 0;
            $diff = 0;
            $final_amount_voucher = 0;

            foreach (session('cart') as $id => $details){
                $whole = 0;
                $half = 0;
                $nq = 0;
                $h = 0;
                $discount = 0;

                $hash = md5(env('SECRETPASS')."~".$details['name']."~".$details['price']."~".$details['prom']."~".$details['fee']."~".$details['width']."~".$details['height']."~".$details['length']."~".$details['weight']);

                if ($hash == $details['hash']){

                    $weight = $weight + ($details['weight'] * $details['quantity']);
                    $volweight = $volweight + ((($details['width']/100)*($details['length']/100)*($details['height']/100)*400) * $details['quantity']);
                    $totalprice = $totalprice + ($details['price'] * $details['quantity']);
                }else{
                    $sw = 1;
                    break;
                }
                
            }

            if ($sw == 0){
                //$apiauth =array('UserName'=>'username','Password'=>'password');
                
                
                if (Auth::user()){

                    $id = Auth::user()->id;
                    $now = new \DateTime();
                    $date_giveaway = $now->format('Y-m-d');

                    $member_info = Member::select('members.email', 'members.firstname','members.lastname','members.address', 'members.delivery_address', 'members.phone', 'members.city', 'members.dpt', 'members.country', 'members.n_doc')
                    ->where('user_id', $id)
                    ->first();

                    $address = Address::select('addresses.id as addressId', 'addresses.address', 'addresses.zipcode', 'addresses.contact', 'addresses.details', 'c.country_master_name', 'd.department', 'ct.city_d_id', 'ct.dane_d', 'ct.cost_pack', 'ct.cost_m_1k', 'ct.cost_m_2k', 'ct.cost_m_3k', 'ct.cost_m_4k', 'ct.cost_m_5k')
                    ->join('countries as c', 'c.country_master_id', 'addresses.country')
                    ->join('departments as d', 'd.code', 'addresses.dpt')
                    ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
                    ->where('user_id', $id)
                    ->where('default', 1)->first();

                    $giveaway_voucher = 0;
                    $giveaway = Voucher::where('user_id', $id)->where('type', 2)->where('start_in', '<=', $date_giveaway)->where('end_in', '>=', $date_giveaway);
                   
                    
                    if($giveaway->exists()){
                        
                        $giveaway_info = $giveaway->first();
                        
                        if (($giveaway_info->status == "open") and ($giveaway_info->amount > 0)){
                            $giveaway_voucher = 1;
                        }else if ($giveaway_info->status == "processing"){
                            $giveaway_voucher = 2;
                        }
                    
                    }

                    //bring product array from cart
                    $valor_almacenado = session('cart');
                    $new_array = array_values($valor_almacenado);

                    if ($totalprice >= 150000){
                        $message = "";
                        $deliveryCost = "free";

                        session()->put('deliveryCost', $deliveryCost);

                        //verify if there is a voucher giveaway return array(totalprice, voucher_amount, diff, final_amount_voucher)
                        if(session()->get('vouchergiveaway')){

                            //verify if there is a voucher giveaway
                            $validate_giveaway = $this->verify_giveaway($id, $totalprice); 
                            $diff = $validate_giveaway[2];
                            $final_amount_voucher = $validate_giveaway[3];
                        }

                        // $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~".$ref_trans."~".$suma."~".$currency);
                        $orderStatus = $this->validateOrder($id, $member_info, $method, $totalprice, $address, $new_array, $diff, $final_amount_voucher);

                        if ($orderStatus[0] == "345"){
                            return redirect()->back()->withErrors("Un error ha ocurrido!!");
                        }

                        $firma = md5(env('SECRETPASS')."~".$totalprice."~100498-".$orderStatus[1]); 

                        session()->put('myorder', $orderStatus[1]);

                        // $giveaway_voucher == 2 update vocuher with diff and amount
                        if ($giveaway_voucher == 2){
                            if ($diff == 0){
                                $giveaway_info->amount_spent = $totalprice;
                                $giveaway_info->amount = $final_amount_voucher;
                            }
                            if ($final_amount_voucher == 0){
                                $giveaway_info->amount_spent = $validate_giveaway[1];
                                $giveaway_info->amount = $final_amount_voucher;
                            }
                            $giveaway_info->save();
                            $totalprice3 = $diff;
                            $descr = "Pay-U: Compra de Productos Naturales GA";
                        }else{
                            $totalprice3 = $totalprice;
                            $descr = "Pay-U: Compra de Productos Naturales";
                        }

                        $firma = md5(env('SECRETPASS')."~".$totalprice3."~100498-".$orderStatus[1]); 
                        $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~100498-".$orderStatus[1]."~".$totalprice3."~".$currency);

                        return view('method', [
                            'answer' => $answer,
                            'cardexist' => $cardExist,
                            'member_info' => $member_info,
                            'address' => $address,
                            'card' => $card,
                            'message' => $message,
                            'delivery_cost' => $deliveryCost,
                            'supertotal' => $totalprice3,
                            'firma' => $firma,
                            'signature' => $signature,
                            'orderId' => $orderStatus[1],
                            'giveaway' => $giveaway_voucher,
                            'description' => $descr
                        ]);
                    }else if (session()->get('voucher')){
                        $message = "";
                        $deliveryCost = "freeVoucher";

                        session()->put('deliveryCost', $deliveryCost);

                        $orderStatus = $this->validateOrder($id, $member_info, $method, $totalprice, $address, $new_array, $diff, $final_amount_voucher);

                        if ($orderStatus[0] == "345"){
                            return redirect()->back()->withErrors("Un error ha ocurrido!!");
                        }
                        session()->put('myorder', $orderStatus[1]);

                        $firma = md5(env('SECRETPASS')."~".$totalprice."~100498-".$orderStatus[1]); 
                        $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~100498-".$orderStatus[1]."~".$totalprice."~".$currency);

                        return view('method', [
                            'answer' => $answer,
                            'cardexist' => $cardExist,
                            'member_info' => $member_info,
                            'address' => $address,
                            'card' => $card,
                            'message' => $message,
                            'delivery_cost' => $deliveryCost,
                            'supertotal' => $totalprice,
                            'firma' => $firma,
                            'signature' => $signature,
                            'orderId' => $orderStatus[1]
                        ]);
                    }else{
                        $deliveryCost = "TCC";
                        //dd($address);

                        // $card = Creditcard::where('user_id', $id)->where('default', 1)->get();

                        // if ($card->count() >0){
                        //     $cardExist = 2;
                        // }
                        
                        $today = $now->format('d/m/Y');
                        
                        $wsdl = "http://clientes.tcc.com.co/preservicios/liquidacionacuerdos.asmx?wsdl";
                        $parameters = [
                            'Clave' => env('TCC_PASS'),
                            'Liquidacion' => [
                                'tipoenvio' => 2,
                                'idciudadorigen' => '08001000',
                                'idciudaddestino' => $address->dane_d,
                                'valormercancia' => $totalprice,
                                'boomerang' => 0,
                                'cuenta' => 5785500,
                                'fecharemesa' => $today,
                                'idunidadestrategicanegocio' => 2,
                                'unidades' => [
                                    'unidad' => [
                                        'numerounidades' => 1,
                                        'pesoreal' => $weight,
                                        'pesovolumen' => $volweight,
                                        
                                        'tipoempaque' => '1'
                                    ]
                                ]
                            ]

                        ];

                        $soap = new SoapClient($wsdl);
                        $re = $soap->__soapCall("ConsultarLiquidacion2", array($parameters));
                        dd($re->consultarliquidacion2Result);

                        if ($re->consultarliquidacion2Result){
                            if (!empty($re->consultarliquidacion2Result->idliquidacion)){
                                session()->put('tcc', $re); 
                                $message = "";
                                $deliveryCost = "payment";

                                session()->put('deliveryCost', $deliveryCost);

                                $subtotalprice = $totalprice + $re->consultarliquidacion2Result->total->totaldespacho;
                                $totalprice2 = intval($subtotalprice);

                                //verify if there is a voucher giveaway return array(totalprice, voucher_amount, diff, final_amount_voucher)
                                if(session()->get('vouchergiveaway')){
                                    $validate_giveaway = $this->verify_giveaway($id, $totalprice2); 
                                    $diff = $validate_giveaway[2];
                                    $final_amount_voucher = $validate_giveaway[3];
                                }

                                $orderStatus = $this->validateOrder($id, $member_info, $method, $totalprice, $address, $new_array, $diff, $final_amount_voucher);

                                if ($orderStatus[0] == "345"){
                                    return redirect()->back()->withErrors("Un error ha ocurrido!!");
                                }

                                session()->put('myorder', $orderStatus[1]);
                                
                                // $giveaway_voucher == 2 update vocuher with diff and amount
                                if ($giveaway_voucher == 2){
                                    if ($diff == 0){
                                        $giveaway_info->amount_spent = $totalprice2;
                                        $giveaway_info->amount = $final_amount_voucher;
                                        $totalprice3 = 0;
                                    }
                                    if ($final_amount_voucher == 0){
                                        $giveaway_info->amount_spent = $validate_giveaway[1];
                                        $giveaway_info->amount = $final_amount_voucher;
                                        if ($diff > 11000){
                                            $totalprice3 = $diff;
                                        }else{
                                            $totalprice3 = 11000;
                                            
                                        }
                                    }
                                    $giveaway_info->save();
                                    
                                    $descr = "Pay-U: Compra de Productos Naturales GA";
                                }else{
                                    $totalprice3 = $totalprice2;
                                    $descr = "Pay-U: Compra de Productos Naturales";
                                }
                                

                                $firma = md5(env('SECRETPASS')."~".$totalprice3."~100498-".$orderStatus[1]); 
                                $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~100498-".$orderStatus[1]."~".$totalprice3."~".$currency);
                                return view('method', [
                                    'answer' => $answer,
                                    'cardexist' => $cardExist,
                                    'member_info' => $member_info,
                                    'address' => $address,
                                    'card' => $card,
                                    'message' => $message,
                                    'delivery_cost' => $deliveryCost,
                                    'supertotal' => $totalprice3,
                                    'firma' => $firma,
                                    'signature' => $signature,
                                    'orderId' => $orderStatus[1],
                                    'giveaway' => $giveaway_voucher,
                                    'description' => $descr
                                ]);
                            }else{
                                
                                if ($weight >= $volweight){
                                    $cal_weight = $weight;
                                }else{
                                    $cal_weight = $volweight;
                                }

                                if ($cal_weight <= 1){
                                    $val_k = $address->cost_m_1k;
                                }else if (($cal_weight > 1) and ($cal_weight <= 2)){
                                    $val_k = $address->cost_m_2k;
                                }else if (($cal_weight > 2) and ($cal_weight <= 3)){
                                    $val_k = $address->cost_m_3k;
                                }else if (($cal_weight > 3) and ($cal_weight <= 4)){
                                    $val_k = $address->cost_m_4k;
                                }else if (($cal_weight > 4) and ($cal_weight <= 5)){
                                    $val_k = $address->cost_m_5k;
                                }

                                if (($totalprice * 0.01) > 360){
                                    $val_1p = $totalprice * 0.01;
                                }else{
                                    $val_1p = 360;
                                }
                                
                                $val_delivery = $val_k + $val_1p;

                                $subtotalprice = $totalprice + $val_delivery;
                                $totalprice2 = intval($subtotalprice);

                                session()->put('tcc', $val_delivery);
                                $message = "";
                                $deliveryCost = "payment";
                                session()->put('deliveryCost', $deliveryCost);
                                // $message = $re->consultarliquidacion2Result->respuesta->mensaje;
                                // return redirect()->back()->withErrors([$message]);

                                //verify if there is a voucher giveaway return array(totalprice, voucher_amount, diff, final_amount_voucher)
                                if(session()->get('vouchergiveaway')){
                                    $validate_giveaway = $this->verify_giveaway($id, $totalprice2); 
                                    $diff = $validate_giveaway[2];
                                    $final_amount_voucher = $validate_giveaway[3];
                                }

                               $orderStatus = $this->validateOrder($id, $member_info, $method, $totalprice, $address, $new_array, $diff, $final_amount_voucher);

                                if ($orderStatus[0] == "345"){
                                    return redirect()->back()->withErrors("Un error ha ocurrido!!");
                                }

                                session()->put('myorder', $orderStatus[1]);
                                
                                
                                if ($giveaway_voucher == 2){
                                    if ($diff == 0){
                                        $giveaway_info->amount_spent = $totalprice2;
                                        $giveaway_info->amount = $final_amount_voucher;
                                        $totalprice3 = 0;
                                    }
                                    if ($final_amount_voucher == 0){
                                        $giveaway_info->amount_spent = $validate_giveaway[1];
                                        $giveaway_info->amount = $final_amount_voucher;
                                        if ($diff > 11000){
                                            $totalprice3 = $diff;
                                        }else{
                                            $totalprice3 = 11000;

                                        }
                                        
                                    }
                                    $giveaway_info->save();
                                    
                                    $descr = "Pay-U: Compra de Productos Naturales GA";
                                }else{
                                    $totalprice3 = $totalprice2;
                                    $descr = "Pay-U: Compra de Productos Naturales";
                                }
                               
                                $firma = md5(env('SECRETPASS')."~".$totalprice3."~100498-".$orderStatus[1]); 
                                $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~100498-".$orderStatus[1]."~".$totalprice3."~".$currency);
                                return view('method', [
                                    'answer' => $answer,
                                    'cardexist' => $cardExist,
                                    'member_info' => $member_info,
                                    'address' => $address,
                                    'card' => $card,
                                    'message' => $message,
                                    'delivery_cost' => $deliveryCost,
                                    'supertotal' => $totalprice3,
                                    'firma' => $firma,
                                    'signature' => $signature,
                                    'orderId' => $orderStatus[1],
                                    'giveaway' => $giveaway_voucher,
                                    'description' => $descr
                                ]);
                            }
                        }
                    }
                    
                    
                    // if ($re->consultarliquidacionResult->respuesta){
                        // {#1290 ▼
                        //     +"consultarliquidacionResult": {#1302 ▼
                        //         +"respuesta": {#1317 ▼
                        //           +"codigo": "-1"
                        //           +"mensaje": "Actualmente NO se tiene habilitado el servicio para la ruta y tipo de transporte seleccionados."
                        //           +"codigointerno": "-1"
                        //           +"mensajeinterno": "No se envio un origen valido"
                        //         }
                        //       }
                        //     }
                    // }
                
                    
                    
                        
                    //dd($re, $weight, $volweight, $re->consultarliquidacionResult->total->totaldespacho);

                    
                }else{
                
                }

                
            }
        }else{
            return redirect('/home');
        }
        
        
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
        private function validateOrder($id, $member_info, $method, $totalprice, $address, $new_array, $diff, $final_amount_voucher){
            //validating if session('codehash') exists in order table 
            if (Order::where('user_id', $id)->where('code_hash', session('codehash'))->doesntExist()){
                $new_order = New Order();

                //call function in Order model
                $rs = $new_order->insert($member_info, $method, $totalprice, $address);
            
                if($rs[0]){
                    //$order_id=$rs->id;
                    for ($i=0; $i < count($new_array); $i++ ){
                        $new_details = New Order_detail();
                        
                        $ds = $new_details->insert($rs[1], $new_array[$i]);
                    }
                    $orderId = $rs[1];
                    return array("200", $orderId);
                }else{
                    return array("345", "Un error ha ocurrido!!");
                    // redirect()->back()->withErrors("Un error ha ocurrido!!");
                    // return back()->with('notice', 'Un error ha ocurrido!!');
                }
            }else{
                
                $order = Order::select('id')->where('user_id', $id)->where('code_hash', session('codehash'))->first();
                //dd($order, session('codehash'), session('cart'));
                $orderId = $order->id;

                $order->amount = $totalprice;

                if(session()->get('vouchergiveaway')){
                    $order->voucher_id = session()->get('vouchergiveaway')['voucher_id'];
                    $order->type_voucher = session()->get('vouchergiveaway')['voucher_type'];
                }

                if (session('deliveryCost') == "free"){
                    $delivery_cost = 0;
                }else{
                    if (session()->get('tcc')){
                        if(!empty(session('tcc')->consultarliquidacion2Result)){
                            $delivery_cost = session('tcc')->consultarliquidacion2Result->total->totaldespacho;
                        }else{
                            $delivery_cost = session('tcc');
                        }
                       
                    }
                }

                
                $order->delivery_cost = $delivery_cost;
                $order->save();

                $details = Order_detail::where('order_id', $orderId);
                $details->delete();

                for ($i=0; $i < count($new_array); $i++ ){
                    $new_details = New Order_detail();
                    
                    $ds = $new_details->insert($orderId, $new_array[$i]);
                }

                return array("200", $orderId);
            }
        } 

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function generateimg(Request $request)
    {
        //bring product array from cart
        $valor_almacenado = session('cart');

        $new_array = array_values($valor_almacenado);
        // dd($new_array[0]['name']);
        //sql member info
        $id = Auth::user()->id;
        $query = DB::table('members as m')
        ->select('m.email as email', 'm.firstname','m.lastname','m.address', 'm.delivery_address', 'm.city', 'm.dpt', 'm.country', 'm.n_doc', 'c.fullname','c.cardnumber', 'c.expiration', 'c.cvv')
        ->join('creditcards as c', 'm.user_id', '=', 'c.user_id' )
        ->where('m.user_id', $id)->get();

        //new class to insert new order
        $new_order = New Order();

        //call function in Order model
        $rs = $new_order->insert($query[0]);

        if($rs[0]){
            //$order_id=$rs->id;
            $new_details = New Order_detail();
            $ds = $new_details->insert($rs[1], $new_array);
            
        }else{
            return back()->with('notice', 'Un error ha ocurrido!!');
        }

        // create Image from file
        $file = $request->imgname;
        $texto = $request->texto;
        $originalPath = public_path().'/img/';
        $img = Image::make('img/'.$file)->resize(300, 300);


        // write text at position
        $img->text($texto, 20, 150, function($font) {
            $font->file('css/Roboto-Regular.ttf');
            $font->size(12);
            $font->color('#000000');
        });

        // save the file in png format
        $id = Auth::user()->id;
        $img->save('img/'.$rs[1].'.png');

        // bring order info
        $order_info = Order::find($rs[1]);

        
        $data = array($order_info, $new_array);
        //dd($data);
        //generar pdf
        $pdf = PDF::loadView('extends.order', compact('data'))->save('orders/order_'.$rs[1].'.pdf');

        $sending = $this->send($rs[1], $query[0]);
        //dd($sending);
        if ($sending){
            return redirect('thanks')->with('success', 'Usuario creado de manera Exitosa!!');
        }else{

        }
    }

    public function send($order_id, $member){

        $email = Auth::user()->email;
        $mem_id = Auth::user()->id;

        $customer = $member->firstname." ".$member->lastname;

        $customer2 = "CLIENTE: ".$member->firstname." ".$member->lastname." \n"."DIRECCION DE ENTREGA: ".$member->delivery_address." \n"."EMAIL: ".$member->email." \n"."DOCUMENTO: ".$member->n_doc." \n"."TARJETA No: ".$member->cardnumber." \n"."VENCIMIENTO: ".$member->expiration;
       
        //Example
        File::put('orders/member_'.$mem_id.'.txt',$customer2);
        
        $sending = Mail::to($email)->send(new OrderShipped($customer, $order_id));

        return true;
        // Mail::send('emails.Recovery_InventCloud', $data, function($message) use ($data) {
		// 	$message->from('no-reply@inventcloud.com', 'InventCloud');
		// 	$message->to($data['email'],$data['email'])->subject('Recuperación de Contraseña');
		// });
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    private function verify_giveaway($user_id, $subtotal){
        $giveData = session()->get('vouchergiveaway');
        $diff = 0;
        $val_voucher = 0;
        $hash = md5(env('SECRETPASS')."~".$giveData["voucher_id"]."~0~".$giveData["voucher_type"]."~".$giveData["voucher_amount"]);
//dd($hash, $giveData['voucher_hash']);
        if ($hash == $giveData['voucher_hash']){
            if ($subtotal >= $giveData["voucher_value"]){
                $diff = $subtotal - $giveData["voucher_value"];
                
            }else{
                
                $val_voucher = $giveData["voucher_value"] - $subtotal;
            }
        }

        //dd($subtotal, $giveData["voucher_value"], $diff , $val_voucher);
        return array($subtotal, $giveData["voucher_value"], $diff , $val_voucher);
    }
}
