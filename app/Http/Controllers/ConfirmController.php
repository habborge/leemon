<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\SendPurchase;
use App\payment_error;
use App\Member;
use App\Order;
use DateTime;
use Mail;
use Auth;

class ConfirmController extends Controller
{
    public function ConfirmTrans(Request $request){
        
        $commerce_id = $request->id_comercio;
        $payment_id = $request->id_pago;
        // $commerce_id = 30364;
        // $payment_id = "100498-34";
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

                    if ($response->json()['int_cantidad_pagos'] == 1){

                        $info = $response->json()['str_res_pago'];
                        $data_info = explode("|", $info);
                        
                        
                        
                        // PREGUNTAMOS POR LSO RESULATDOS
                        switch ($data_info[4]) {
                            case 200:
                            case 888:
                                $sw = 0;
                                break;
                            case 4001:
                                $sw = 0;
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

                        if ($sw == 1){
                            
                            $orderId = explode("-", $payment_id);
                            $orderPre = Order::where('id', $orderId[1])->where('status', 'Open');

                            if ($orderPre->exists()){
                                $order = $orderPre->first();
                                                       
                                //16/12/2020 9:23:39 PM
                                // $newDate = date("Y-m-d H:i:s", strtotime($data_info[19]));

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

                                if ($approval == 1){
                                    $order_change = Order::approval_order($order->id);

                                    $member = Member::select('user_id','firstname','lastname','email')->where('user_id', $order->user_id)->first();

                                    $sending = Mail::to($member->email)->send(new SendPurchase($order, $member, $rs));

                                    
                                }else{
                                    $order_change = Order::reject_order($order->id);
                                }

                                session()->put('MyOrderId', $order->id);
                            }else{
                                
                            }
                        }

                    }else if ($response->json()['int_cantidad_pagos'] > 1){
                        $info = explode(";", $response->json()['str_res_pago']);
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
            }
        }
        
    }

    //--------------------------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------------------------

    public function BackToCommerce(){
        $user_id = Auth::user()->id;
        $orderIdSession = session()->get('MyOrderId');

        $openOrder = Order::where('user_id', $user_id)->where('id', $orderIdSession);

        if ($openOrder->exists()){

            $order = $orderPre->first();

            $data = [
                "int_id_comercio" => env('ZV_ID'),
                "str_usr_comercio" => env('ZV_CO'),
                "str_pwd_comercio" => env('ZV_PA'),
                "str_id_pago" => "100498-".$order->id,
                "int_no_pago" => -1
            ];
    
            $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/VerificacionPago', $data);
            // if int_estado = 1 then API ran good
            if ($response->json()['int_estado'] == 1){ 

                // if int_error = 0 then API found payments
                if ($response->json()['int_error'] == 0){

                    if ($response->json()['int_cantidad_pagos'] == 1){

                        $info = $response->json()['str_res_pago'];
                        $data_info = explode("|", $info);
                        
                        
                        
                        // PREGUNTAMOS POR LSO RESULATDOS
                        switch ($data_info[4]) {
                            case 200:
                            case 888:
                                $sw = 0;
                                break;
                            case 4001:
                                $sw = 0;
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
                    }else if ($response->json()['int_cantidad_pagos'] > 1){
                        $info = explode(";", $response->json()['str_res_pago']);
                    }
                }else{
                    $message = "No se encontro Información relacionada al pago";                  
                }
            }else{
                $message = "Se presentó problemas con zonapagos";
            }
                        
        }
        return view('confirmPurchase', [
            'approval' => $approval,
            'message' => $message
        ]);

    }
}
