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
    
            if ($info){
                $infosaved = 1;
            }
            
            if ($p->fails()){
                return view('purchase', [
                    'completeRequest' => $request,
                    'infosaved' => $infosaved,
                    'info' => $info,
                    // 'checkbox' => $request->sameaddress
                ])->withErrors($p);
            }else{
                //$res = $this->luhnCheck($request->cc_number);
                
                // $user_info = New Member();
                // $rs = $user_info->set($request);
                
                if($info){
                    
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
                    return view('purchase', [
                        'completeRequest' => $request,
                        'infosaved' => $infosaved,
                        'info' => $info,
                        //'checkbox' => $request->sameaddress,
                        
                    ])->withErrors($error);    
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
        
        if ((Auth::user()) and (session('cart'))){
            
            $answer = 1;
            $cardExist = 0;
            $member_info = null;
            $card = null;
            $address = null;
            $weight = 0;
            $volweight = 0;
            $sw = 0;
            $totalprice = 0;

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
                    $address = Address::where('user_id', $id)->where('default', 1)
                    ->join('countries as c', 'c.country_master_id', 'addresses.country')
                    ->join('departments as d', 'd.code', 'addresses.dpt')
                    ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
                    ->first();

                    if ($totalprice > 150000){
                        $message = "";
                        $deliveryCost = "free";

                        session()->put('deliveryCost', $deliveryCost);

                        return view('method', [
                            'answer' => $answer,
                            'cardexist' => $cardExist,
                            'member_info' => $member_info,
                            'address' => $address,
                            'card' => $card,
                            'message' => $message,
                            'delivery_cost' => $deliveryCost,
                        ]);
                    }else if (session()->get('voucher')){
                        $message = "";
                        $deliveryCost = "freeVoucher";

                        session()->put('deliveryCost', $deliveryCost);

                        return view('method', [
                            'answer' => $answer,
                            'cardexist' => $cardExist,
                            'member_info' => $member_info,
                            'address' => $address,
                            'card' => $card,
                            'message' => $message,
                            'delivery_cost' => $deliveryCost,
                        ]);
                    }else{
                        $deliveryCost = "TCC";
                        //dd($address);

                        // $card = Creditcard::where('user_id', $id)->where('default', 1)->get();

                        // if ($card->count() >0){
                        //     $cardExist = 2;
                        // }

                        $wsdl = "http://clientes.tcc.com.co/preservicios/liquidacionacuerdos.asmx?wsdl";
                        $parameters = [
                            'Clave' => 'CLIENTETCC608W3A61CJ',
                            'Liquidacion' => [
                                'tipoenvio' => 2,
                                'idciudadorigen' => '08001000',
                                'idciudaddestino' => $address->dane_d,
                                'valormercancia' => $totalprice,
                                'boomerang' => 0,
                                'cuenta' => 0,
                                'fecharemesa' => '05/02-2021',
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
                        $re = $soap->__soapCall("ConsultarLiquidacion", array($parameters));
                        //dd($re->consultarliquidacionResult);

                        if ($re->consultarliquidacionResult){
                            if (!empty($re->consultarliquidacionResult->idliquidacion)){
                                session()->put('tcc', $re); 
                                $message = "";
                                $deliveryCost = "payment";

                                session()->put('deliveryCost', $deliveryCost);

                                return view('method', [
                                    'answer' => $answer,
                                    'cardexist' => $cardExist,
                                    'member_info' => $member_info,
                                    'address' => $address,
                                    'card' => $card,
                                    'message' => $message,
                                    'delivery_cost' => $deliveryCost,
                                ]);
                            }else{
                                $message = $re->consultarliquidacionResult->respuesta->mensaje;
                                return redirect()->back()->withErrors([$message]);
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
}
