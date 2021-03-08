<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\SendPurchase;
use App\payment_error;
use App\Order_detail;
use App\Product;
use App\Member;
use App\Order;
use DateTime;
use Mail;
use Auth;

class ConfirmController extends Controller
{
    //---------------------------------------------------------------------------------------------------------
    private function verifyInfo($info, $payment_id){
        $data_info = explode("|", $info);
        $sw = 0;
        $approval = 0;
        $message = "";
        // PREGUNTAMOS POR LSO RESULATDOS
        switch ($data_info[4]) {
            case 200:
            case 888:
                $sw = 0;
                $approval = 2;
                break;
            case 4001:
                $sw = 0;
                $approval = 2;
                if ($data_info[20] == 32){
                    $message = "En este momento su Número de Referencia o Factura (100498-".$payment_id.") presenta un proceso de pago cuya
                    transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, por favor
                    espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa.
                    Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de
                    atención al cliente 57-1-9999999 o enviar un correo electrónico a soporte@leemon.com.co.";
                }
                break;
            case 999:
                $sw = 0;
                $approval = 2;
                if ($data_info[20] == 29){
                    $message = "En este momento su Numero de Referencia o Factura (100498-".$payment_id.") presenta un proceso de pago cuya
                    transacción se encuentra PENDIENTE de recibir confirmación por parte de su entidad financiera, por favor
                    espere unos minutos y vuelva a consultar más tarde para verificar si su pago fue confirmado de forma exitosa.
                    Si desea mayor información sobre el estado actual de su operación puede comunicarse a nuestras líneas de
                    atención al cliente 57-1-9999999 o enviar un correo electrónico a soporte@leemon.com.co y preguntar por el
                    estado de la transacción: ".$data_info[25];
                }
                break;
            case 777:
                $sw = 1;
                break;
            case 4000:
                $sw = 1;
                $message = "Su transacción fue Rechazada";
                break;
            case 4003:
                $sw = 1;
                $message = "Hubo un Error CR y Su transacción fue Rechazada";
                break;
            case 1000:
                $message = "Su transacción fue Rechazada";
                $sw = 1;
                break;
            case 1001:
                $message = "Su transacción fue Rechazada, ha surgido un Error entre ACH y el Banco";
                $sw = 1;
                break;
            case 1002:
                $sw = 1;
                break;
            case 1:
                $sw = 1;
                $approval = 1;
                $message = "Su transacción ha sido Aprovada!!";
                break;
        }

        return array($approval, $sw, $message, $data_info);
    }

    //---------------------------------------------------------------------------------------------------------
    //
    //---------------------------------------------------------------------------------------------------------
    private function insertInfoError($order, $response, $data_info){
        $rs = new payment_error();

        $rs->reference_code = $order->code_hash;
        $rs->user_id = $order->user_id;
        $rs->order_id = $order->id;
        $rs->description = "100498-".$order->id."~".$response;
        $rs->pedido_num = $data_info[0];
        $rs->payment_num = $data_info[1];
        $rs->partial_payment = $data_info[2];
        $rs->finish_payment = $data_info[3];
        $rs->status_payment = $data_info[4];
        $rs->amount_paid = $data_info[5];
        $rs->total_paid = $data_info[6];
        $rs->fee_paid = $data_info[7];
        $rs->purchase_desc = $data_info[8];
        $rs->n_doc = $data_info[9];
        $rs->fullname = $data_info[10]." ".$data_info[11];
    
        $rs->phone = $data_info[12];
        $rs->email = $data_info[13];
        $rs->options = $data_info[14]."~".$data_info[15]."~".$data_info[16]."~".$data_info[17]."~".$data_info[18];
        $rs->purchase_date = $data_info[19];
        $rs->id_forma_pago = $data_info[20];

        if ($data_info[20] == 29){
            $rs->ticket_id = $data_info[21];
            $rs->service_code = $data_info[22];
            $rs->bank_code = $data_info[23];
            $rs->bank_name = $data_info[24];
            $rs->transaction_code = $data_info[25];
            $rs->transaction_cycle = $data_info[26];
            
        }else if ($data_info[20] == 32){
            $rs->ticket_id = $data_info[21];
            $rs->last4num = $data_info[22];
            $rs->cc_franchise = $data_info[23];
            $rs->approval_code = $data_info[24];
            $rs->number_received = $data_info[25];
        }

        $rs->save();
        return array(1, $rs);
    }

    //---------------------------------------------------------------------------------------------------------
    //
    //---------------------------------------------------------------------------------------------------------
    public function ConfirmTrans(Request $request){
        
        $commerce_id = $request->id_comercio;
        $payment_id = $request->id_pago;
        // $commerce_id = 30364;
        // $payment_id = "100498-1";
        $message = "";
        $sw = 0;
        $approval = 0;
        
        if ($commerce_id == env('ZV_ID')){

            $data = [
                "int_id_comercio" => env('ZV_ID'),
                "str_usr_comercio" => env('ZV_CO'),
                "str_pwd_comercio" => env('ZV_PA'),
                "str_id_pago" => $payment_id,
                "int_no_pago" => -1
            ];

            $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/VerificacionPago', $data);

            //dd($response->json());

            // if int_estado = 1 then API ran good
            if ($response->json()['int_estado'] == 1){ 

                // if int_error = 0 then API found payments
                if ($response->json()['int_error'] == 0){
                    $orderId = explode("-", $payment_id);
                    $orderPre = Order::where('id', $orderId[1]);

                    if ($response->json()['int_cantidad_pagos'] == 1){

                        $info = $response->json()['str_res_pago'];
                        $result = $this->verifyInfo($info, $payment_id);
                        $data_info = $result[3];
                        
                        // array($approval, $sw, $message); if sw = 1
                        if ($result[1] == 1){
                            
                            

                            if ($orderPre->exists()){
                                $order = $orderPre->first();

                                $insertData = $this->insertInfoError($order, $response, $data_info);                       
                                //16/12/2020 9:23:39 PM
                                // $newDate = date("Y-m-d H:i:s", strtotime($data_info[19]));

                                if ($insertData[1]){
                                    // array($approval, $sw, $message);
                                    if ($result[0] == 1){
                                        $order_change = Order::approval_order($order->id, $data_info[20]);
                                        $products_discount = $this->updateQuantity($order->id);

                                        $info_trans = $insertData[1];
                                        $member = Member::select('user_id','firstname','lastname','email')->where('user_id', $order->user_id)->first();
                                        $sending = Mail::to($member->email)->send(new SendPurchase($order, $member, $info_trans));
                                    }else{
                                        // int_pago_terminado => 1: Terminado => 2: Pendiente: En caso de que el pago sea mixto. El pago no ha sido terminado en su totalidad. => 200 Pago iniciado
                                        if ($data_info[3] == 1){
                                            $order_change = Order::reject_order($order->id);
                                        }
                                    }
                                }
                            }else{
                                
                            }
                        }else{
                            // $orderId = explode("-", $payment_id);
                            // $orderPre = Order::where('id', $orderId[1])->where('status', 'Open');

                            if ($orderPre->exists()){
                                $order = $orderPre->first();

                                $insertData = $this->insertInfoError($order, $response, $data_info);
                                if ($insertData[1]){
                                    // array($approval, $sw, $message); var approval is 1 transaction was approved, if var approval is 0 was rejected
                                    if ($result[0] == 2){
                                        $order_change = Order::pending_order($order->id);
                                        // $order_status = 2;
                                    }
                                }
                            }
                        }

                    }else if ($response->json()['int_cantidad_pagos'] > 1){
                        $info = explode(";", $response->json()['str_res_pago']);
                        $order_status = 0;
                        for ($i=0; $i < count($info) -1; $i++) { 
                            $result = [];
                            $result = $this->verifyInfo($info[$i], $payment_id);
                            $data_info = $result[3];
                            
                            // array($approval, $sw, $message); if sw = 1 transaction was approved or reject
                            if ($result[1] == 1){
                                if ($orderPre->exists()){
                                    $order = $orderPre->first();
                                    $insertData = $this->insertInfoError($order, $response, $data_info);
                                    
                                    // if insert works
                                    if ($insertData[1]){
                                        // array($approval, $sw, $message); var approval is 1 transaction was approved, if var approval is 0 was rejected
                                        if ($result[0] == 1){
                                            $order_change = Order::approval_order($order->id, $data_info[20]);
                                            $products_discount = $this->updateQuantity($order->id);
                                            $order_status = 1;

                                            $info_trans = $insertData[1];
                                            $member = Member::select('user_id','firstname','lastname','email')->where('user_id', $order->user_id)->first();
                                            $sending = Mail::to($member->email)->send(new SendPurchase($order, $member, $info_trans));
                                            break;
                                        }else{
                                            //$order_change = Order::reject_order($order->id);
                                            $order_status = 0;
                                        }
                                    }
                                }
                                
                        
                            }else{
                                // pending_order sw = 0 transaction is pending -> case 200, 888, 999, 4001  
                                $insertData = $this->insertInfoError($order, $response, $data_info);
                                if ($insertData[1]){
                                    // array($approval, $sw, $message); var approval is 1 transaction was approved, if var approval is 0 was rejected
                                    if ($result[0] == 2){
                                        //$order_change = Order::pending_order($order->id);
                                        $order_status = 2;
                                    }
                                }
                            }
                        }
                            if ($order_status == 0){
                                $order_change = Order::reject_order($order->id);
                            }else if ($order_status == 2){
                                $order_change = Order::pending_order($order->id);
                            }
                    }
                }else{
                    // payment_error::insertarError($response);
                    $order_change = Order::reject_order($order->id);

                    $rs = new payment_error();
                    $rs->reference_code = $order->reference_code;
                    $rs->user_id = $order->user_id;
                    $rs->order_id = $order->id;
                    $rs->description = "100498-".$order->id."~".$response;
                    $rs->save(); 
                    
                }
            }else{

            }
        }
        
    }

    //--------------------------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------------------------

    public function BackToCommerce(){

        //return redirect()->away("https://leemon.com.co/secure/methods/zp/back");
        
        $message = "";
        $sw = 0;
        $approval = 0;

        if (Auth::user()){
            $user_id = Auth::user()->id;
            $orderIdSession = session()->get('myorder');

            //$orderIdSession = 80;
            $openOrder = Order::where('user_id', $user_id)->where('id', $orderIdSession);
            //dd($orderIdSession);
            //dd($openOrder->first());
            if ($openOrder->exists()){

                $order = $openOrder->first();

                $data = [
                    "int_id_comercio" => env('ZV_ID'),
                    "str_usr_comercio" => env('ZV_CO'),
                    "str_pwd_comercio" => env('ZV_PA'),
                    "str_id_pago" => "100498-".$order->id,
                    "int_no_pago" => -1
                ];
        
                $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/VerificacionPago', $data);
                //dd($response->json());
                // dd(session()->all());
                // if int_estado = 1 then API ran good
                if ($response->json()['int_estado'] == 1){ 

                    // if int_error = 0 then API found payments
                    if ($response->json()['int_error'] == 0){

                        if ($response->json()['int_cantidad_pagos'] == 1){

                            $info = $response->json()['str_res_pago'];
                            $data_info = explode("|", $info);
                            
                            
                            $result = $this->verifyInfo($info, $order->id);
                            
                            //array($approval, $sw, $message, $data_info);
                            // PREGUNTAMOS POR LSO RESULATDOS
                            $approval = $result[0];
                            $message = $result[1];
                            $dataTransaction = $data_info;

                        }else if ($response->json()['int_cantidad_pagos'] > 1){
                            $info = explode(";", $response->json()['str_res_pago']);
                        
                            // $output = new ConsoleOutput();
                            // $output->writeln("<info>Converting".$response->json()['str_res_pago']."</info>");

                            $order_status = 0;

                            for ($i=0; $i < count($info) -1; $i++) { 
                                $result = [];
                                $result = $this->verifyInfo($info[$i], $order->id);
                                $data_info = $result[3];
                                $order_status = $result[0];
                                $order_message = $result[2];
                            }

                            $approval = $order_status;
                            $message = $order_message;
                            $dataTransaction = $data_info;
                        }

                        if ($approval == 1){
                            //session()->flush();
                            session()->forget('cart', 'myorder', 'codehash');
                        }
                    }else{
                        $message = "No se encontro Información relacionada al pago";      
                        $dataTransaction = "error";            
                    }
                }else{
                    $message = "Se presentó problemas con zonapagos";
                    $dataTransaction = "error";
                }
                
            }else{
                $message = "La orden de compra ya fue procesada";
                $dataTransaction = "error";
            }
        }else{
            $message = "Esta información ya ha sido procesada y entregada";
            $dataTransaction = "error";
        }

        

        // $data_info[0] = 31; 
        // $data_info[1] = 3772; //reference
        // $data_info[2] = 1;  
        // $data_info[3] = 200;
        // $data_info[4] = 1002; 
        // $data_info[5] = 12500; 
        // $data_info[6] = 12500;
        // $data_info[7] = 13;
        // $data_info[8] = "Compra de Productos Naturales";
        // $data_info[9] = 72005823; //docuemnto
        // $data_info[10] = "Cristina";
        // $data_info[11] = "Vargas";
        // $data_info[12] = 319632555648; //tel
        // $data_info[13] = "soporte9@zonavirtual.com";
        // $data_info[14] = "str_opcional1";
        // $data_info[15] = "str_opcional2";
        // $data_info[16] = "str_opcional3";
        // $data_info[17] = "str_opcional4";
        // $data_info[18] = "str_opcional5";
        // $data_info[19] = "9/11/2018 12:58:41 PM";
        // $data_info[20] = 29; 

        // if ($data_info[20] == 29){
        //     $data_info[21] = 18092100031;
        //     $data_info[22] = 2701;
        //     $data_info[23] = 1022; 
        //     $data_info[24] = "BANCO UNION COLOMBIANO"; 
        //     $data_info[25] = 1468228; 
        //     $data_info[26] = 3;
        // }else{
        //     $data_info[21] = "18092100031";
        //     $data_info[22] = 2701;
        //     $data_info[23] = "Diners Club, American Express, Visa, Master Card"; 
        //     $data_info[24] = 56844; 
        //     $data_info[25] = 4532211566;
        // }
        // $approval = 1;
        // $dataTransaction = $data_info;
        
        return view('confirmPurchase', [
            'approval' => $approval,
            'message' => $message,
            'response' => $dataTransaction
        ]);

    }

    private function updateQuantity($order_id){
        $products = Order_detail::where('order_id', $order_id)->get();

        foreach ($products as $product) {
            $pro = Product::where('id', $product->product_id)->first();
            $value = $pro->quantity - $product->quantity;
            
            $pro->quantity = $value;
            $pro->save();
        }
    }

    
}
