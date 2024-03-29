<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\PurchaseTrait;
use App\Member;
use App\Address;
use App\Order;
use App\Order_detail;
use Auth;

class PaymentController extends Controller
{
    use PurchaseTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paymentProcess(Request $request){

        //$method = $request->methodPay;
        //dd("aqui");
        $method = 2;

        // $subTotal = 0;
        // $total = 0;
        // $q_prod = 0;
        // $delivery = 0;
        // $total_d = 0;
        // $beforeFee = 0;
        // $fee = 0;
        // $sw = 0;
        $part = explode("-", $request->referenceId);
        $order_id = $part[1];
        
        $totalprice = $request->total;
        $sign = $request->sign;
        
        // $firma = md5(env('SECRETPASS')."~".$totalprice."~100498-".$orderStatus[1]);  from purchaseController
        $firma = md5(env('SECRETPASS')."~".$totalprice."~100498-".$order_id);

      
        if (session('cart')){
            
            if ($firma == $sign){

                //$cart = session()->get('cart');
                $codehash = session()->get('codehash');
            
            
                if (session('myorder')){
                    $orderExists = session()->get('myorder');
                    $resp_pending = $this->validatePending($orderExists);
                    if (($resp_pending[0] == 200) and ($resp_pending[1] == 2)){ 
                        return response()->json(['status'=>506, 'url' => '', 'order_exists' => $orderExists, 'status_pse' => $resp_pending[2][4], 'message' => $resp_pending[3]]);
                    }
                }

                // foreach (session('cart') as $id => $details){
                //     $whole = 0;
                //     $half = 0;
                //     $nq = 0;
                //     $h = 0;
                //     $discount = 0;

                //     $hash = md5(env('SECRETPASS')."~".$details['name']."~".$details['price']."~".$details['prom']."~".$details['fee']."~".$details['width']."~".$details['height']."~".$details['length']."~".$details['weight']);

                //     if ($hash == $details['hash']){

                //         $q_prod += $details['quantity'];
                //         $total += ($details['price'] * $details['quantity']);
                //         $total_d += $half + $discount;
                //         $subTotal += ($details['price'] * $nq);
    
                //     }else{
                //         $sw = 1;
                //         break;
                //     }
                    
                // }
                $user_id = Auth::user()->id;

               // if request->methodPay = 1 is credit card, 2 is PSE, 3 others 
                
                $member = Member::where('user_id', $user_id)->first();
                $methodCode = env('METHOD_PSE');
                
                
                $address = Address::select('addresses.id as addressId', 'addresses.address', 'addresses.zipcode', 'addresses.contact', 'addresses.details', 'c.country_master_name', 'd.department', 'ct.city_d_id')
                ->join('countries as c', 'c.country_master_id', 'addresses.country')
                ->join('departments as d', 'd.code', 'addresses.dpt')
                ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
                ->where('user_id', $user_id)
                ->where('default', 1)->first();
                
                //bring product array from cart
                // $valor_almacenado = session('cart');
                // $new_array = array_values($valor_almacenado);

                //validating if session('codehash') exists in order table 
                // if (Order::where('user_id', $user_id)->where('code_hash', session('codehash'))->doesntExist()){
                //     $new_order = New Order();

                //     //call function in Order model
                //     $rs = $new_order->insert($member, $method, $total, $address);
                
                //     if($rs[0]){
                //         //$order_id=$rs->id;
                //         for ($i=0; $i < count($new_array); $i++ ){
                //             $new_details = New Order_detail();
                            
                //             $ds = $new_details->insert($rs[1], $new_array[$i]);
                //         }
                //         $orderId = $rs[1];
                        
                //     }else{
                //         return redirect()->back()->withErrors("Un error ha ocurrido!!");
                //         // return back()->with('notice', 'Un error ha ocurrido!!');
                //     }
                // }else{
                //     $order = Order::select('id')->where('user_id', $user_id)->where('code_hash', session('codehash'))->first();
                //     $orderId = $order->id;
                // }   

                // session()->put('myorder', $orderId);
                // //new class to insert new order

                // if (session()->get('deliveryCost')){
                //     if (session('deliveryCost') == "freeVoucher"){
                //         if (session()->get('voucher')){
                            
                //             $delivery_cost = session('voucher')['voucher_cost'];
                            
                //         }
                //     }else if (session('deliveryCost') == "free"){
                //         $delivery_cost = 0;
                //     }else{
                //         if (session()->get('tcc')){
                //             $delivery_cost = session('tcc')->consultarliquidacionResult->total->totaldespacho;
                //         }
                //     }
                // }
                
                // $re = session()->get('tcc'); 
                // $totalFinal =  $total + $re->consultarliquidacionResult->total->totaldespacho;
                // $totalFinal =  $total + $delivery_cost;
                // $reference = $user_id."~";
                $orderId = $order_id;
                $update_method = Order::find($orderId);
                $update_method->method = 2;
                $update_method->save();
                
                $totalFinal = $totalprice;
                
                $data = [
                    "InformacionPago" => [
                        "flt_total_con_iva" => $totalFinal,
                        "flt_valor_iva" => 0,
                        "str_id_pago" => "100498-".$orderId,
                        "str_descripcion_pago" => "Compra de Productos Naturales",
                        "str_email" => $member->email,
                        "str_id_cliente" => $member->n_doc,
                        "str_tipo_id" => "1",
                        "str_nombre_cliente" => $member->firstname,
                        "str_apellido_cliente" => $member->lastname,
                        "str_telefono_cliente" => $member->phone,
                        "str_opcional1" => "opcion 11",
                        "str_opcional2" => "opcion 12",
                        "str_opcional3" => "opcion 13",
                        "str_opcional4" => "opcion 14",
                        "str_opcional5" => "opcion 15"
                    ],
                    "InformacionSeguridad" => [
                        "int_id_comercio" => env('ZV_ID'),
                        "str_usuario" => env('ZV_CO'),
                        "str_clave" => env('ZV_PA'),
                        "int_modalidad" => 1
                    ],
                    "AdicionalesPago" => [
                            [
                                "int_codigo" => 111,
                                "str_valor" => "0"
                            ],
                            [
                                "int_codigo" => 112,
                                "str_valor" => "0"
                            ]
                    ],
                    "AdicionalesConfiguracion" => [
                        [
                            "int_codigo" => 50,
                            "str_valor" => $methodCode
                        ],
                        [
                            "int_codigo" => 100,
                            "str_valor" => "2"
                        ],
                        [
                            "int_codigo" => 101,
                            "str_valor" => "0"
                        ],
                        [
                            "int_codigo" => 102,
                            "str_valor" => "0"
                        ],
                        [
                            "int_codigo" => 103,
                            "str_valor" => "0"
                        ],
                        [
                            "int_codigo" => 104,
                            "str_valor" => env('APP_URL')."/secure/methods/zp/back"
                        ],
                        [
                            "int_codigo" => 105,
                            "str_valor" => "1"
                        ],
                        [
                            "int_codigo" => 106,
                            "str_valor" => "3"
                        ],
                        [
                            "int_codigo" => 107,
                            "str_valor" => "0"
                        ],
                        [
                            "int_codigo" => 108,
                            "str_valor" => "1"
                        ],
                        [
                            "int_codigo" => 109,
                            "str_valor" => "0"
                        ],
                        [
                            "int_codigo" => 110,
                            "str_valor" => "0"
                        ],
                    ]
        
                ];
                
               
                $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/InicioPago', $data);

                //dd($response->json());
                if ($response->json()['int_codigo'] == 1){ 
                    return redirect()->away($response->json()['str_url']);
                }else{
                    return redirect()->back()->withErrors("No se pudo conectar a ZonaPagos, por favor intente de nuevo!!");
                }   
               // return redirect()->to($response->json()['str_url']);
                
                //dd($response->json(),json_encode($data),$response->json()['str_url']);

                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL,'https://www.zonapagos.com/Apis_CicloPago/api/InicioPago');

                // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
                // curl_setopt($ch, CURLOPT_POST, 1); 
                // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // $response = curl_exec($ch);
                
                // curl_close($ch);
        
               // dd($response, json_encode($data));

                //return response()->json(['status'=>200, 'url' => $response->json()['str_url']]);
            }else{
                return redirect()->back()->withErrors("Productos del carrito manipulados!!");
            }
        }else{
            return redirect()->back()->withErrors("Su sesión del carrito ha expirado!!");
        }

       

    }
}
