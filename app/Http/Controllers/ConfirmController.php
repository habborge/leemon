<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\SendPurchase;
use App\Mail\SendPurchasePayU;
use App\payment_error;
use App\Payu_payment;
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
    private function insertInfoPayU($order_id, $request){
        $payment = Payu_payment::where('order_id', $order_id);
        $info = json_encode($request, true);

        if ($payment->exists()){

            $new_payment = $payment->first();

            $new_payment->method = 5;
            $new_payment->reference = $request['reference_sale'];
            $new_payment->signature = $request['sign'];
            $new_payment->error = $info;
           
            $new_payment->save();

        }else{
            
            $new_payment = new Payu_payment();

            $new_payment->order_id = $order_id;
            $new_payment->method = 5;
            $new_payment->reference = $request['reference_sale'];
            $new_payment->signature = $request['sign'];
            $new_payment->error = $info;
           
            $new_payment->save();
        }

        return array(1, $new_payment);
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

                                        if ($order_change[0] == 0){
                                            $products_discount = $this->updateQuantity($order->id);
                                        }

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

                                            if ($order_change[0] == 0){
                                                $products_discount = $this->updateQuantity($order->id);
                                            }

                                            $order_status = 1;

                                            $info_trans = $insertData[1];
                                            $member = Member::select('user_id','firstname','lastname','email')->where('user_id', $order->user_id)->first();
                                            $sending = Mail::to($member->email)->bcc(env('MAIL_BCC_ADDRESS'))->send(new SendPurchase($order, $member, $info_trans));
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
        $orderIdSession = 0;

        if (Auth::user()){
            $user_id = Auth::user()->id;
            $orderIdSession = session()->get('myorder');

            //$orderIdSession = 1;
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
        $url = json_encode($dataTransaction,TRUE);
        $lru = $orderIdSession."~".$url;
        $url2 = base64_encode($lru);

        return view('confirmPurchase', [
            'approval' => $approval,
            'message' => $message,
            'response' => $dataTransaction,
            'url' => $url2,
        ]);

    }

    //---------------------------------------------------------------------------------------------------------
    //
    //---------------------------------------------------------------------------------------------------------
    public function ConfirmTransPayU($request){

        /*response_code_pol=1
        phone=
        additional_value=0.00
        test=1
        transaction_date=2015-06-11 13:30:26 06/11/2015 13:30:26
        cc_number=************0004
        cc_holder=test_buyer
        error_code_bank=
        billing_country=CO
        bank_referenced_name=
        description=test_payu_01
        administrative_fee_tax=0.00
        value=330.00
        administrative_fee=0.00
        payment_method_type=2
        office_phone=
        email_buyer=test@payulatam.com
        response_message_pol=ENTITY_DECLINED
        error_message_bank=
        shipping_city=
        transaction_id=f5e668f1-7ecc-4b83-a4d1-0aaa68260862
        sign=be11f47966ffd656308292b1fb91a342
        tax=0.00
        payment_method=10
        billing_address=cll 93
        payment_method_name=VISA
        pse_bank=
        state_pol=4
        date=2015.05.27 01:07:35
        nickname_buyer=
        reference_pol=7069375
        currency=USD
        risk=1.0
        shipping_address=
        bank_id=10
        payment_request_state=R
        customer_number=
        administrative_fee_base=0.00
        attempts=1
        merchant_id=500238
        exchange_rate=2541.15
        shipping_country=
        installments_number=1
        franchise=VISA
        payment_method_id=2
        extra1=
        extra2=
        antifraudMerchantId=
        extra3=
        nickname_seller=
        ip=190.242.116.98
        airline_code=
        billing_city=Bogota
        pse_reference1=
        reference_sale=38-heidy10-3-ynafu97
        pse_reference3=
        pse_reference2=
        */

        // $request->merchant_id=508029;
        // $request->response_code_pol = 1; //El código de respuesta de PayU. 1 es APPROVED
        // $request->state_pol = 4; //Indica el estado de la transacción en el sistema. 4 es APPROVED , 6 es declinada y 7 expirada
        // $request->transaction_date = "2015-06-11 13:30:26"; //fecha de la transccion, si es aprobada se colocar como fecha de registro en el sistema
        // $request->value = 80000.00; //valor pagado
        // $request->transaction_id = "a67cbd9a-5d00-4b17-b82b-afca4e13cfac"; 
        // $request->sign = "7f638a2ae42a24e60d2f8bb809bdeecc";
        // $request->payment_method_name="VISA";
        // $request->reference_sale = "100498-58"; //Es la referencia de la venta o pedido. Deber ser único por cada transacción que se envía al sistema.
        // $request->reference_pol = 7069375; //La referencia o número de la transacción generado en PayU
        // $request->currency="COP";
        // $ref_tran = $request->reference_sale;

        

        if($request['merchant_id'] == env('MERCHANT')){
            
            // Validando si el segundo decimal del parámetro value es cero
            $explota = explode(".",$request['value']);

            if (empty($explota[1])){
                $valor = $explota[0].".0";
            }else{
                //if ($explota[1] == "00")
                $rest = substr($explota[1],1,1);
                if ($rest == "0"){   // devuelve si el segundo digito de los decimales
                    $rest2 = substr($explota[1],0,1);
                    if($rest2 == "0"){
                        $valor = $explota[0].".0";
                    }else{
                        $valor = $explota[0].".".$rest2;
                    }
                
                }else{
                    $valor = $request->value;
                }
            }
            
            //ApiKey~merchant_id~reference_sale~new_value~currency~state_pol
            $signature = md5(env('KEY_PAY')."~".env('MERCHANT')."~".$request['reference_sale']."~".$valor."~".$request['currency']."~".$request['state_pol']);
            $dividir = explode("-",$request['reference_sale']);
            $order_id = $dividir[1];
            
            if ($request['sign'] == $signature){
                $no_aprovo = 0;
                

                // state_pol == 4 La trasaccion fue aprovada
                if($request['state_pol'] == 4){ 

                    if ($request['response_code_pol'] == 1){
                        $order_change = Order::approval_orderPayU($order_id, $request);

                        if ($order_change[0] == 0){
                            $products_discount = $this->updateQuantity($order_id);
                        }

                        $info_trans = $request;
                        $member = Member::select('user_id','firstname','lastname','email')->where('user_id', $order_change[1]->user_id)->first();
                        $sending = Mail::to($member->email)->bcc(env('MAIL_BCC_ADDRESS'))->send(new SendPurchasePayU($order_change[1], $member, $info_trans));


                    }else{
                        $no_aprovo = 1;
                        $error="Error-response_message_pol = ".$response_code_pol;
                    }//end de estatus de response_code_pol
                }else{
                    $no_aprovo = 1;
                    $error="Error-state_pol = ".$state_pol;
                }

                
            }
            $insertData = $this->insertInfoPayU($order_id, $request);
        }
    }

    //---------------------------------------------------------------------------------------------------------
    //
    //---------------------------------------------------------------------------------------------------------
    public function BackToCommercePayU(Request $request){
        $merchantId=$request->merchantId;
        $merchant_name=$request->merchant_name;
        $merchant_address=$request->merchant_address;
        $telephone=$request->telephone;
        $merchant_url=$request->merchant_url;
        $transactionState=$request->transactionState;
        $lapTransactionState=$request->lapTransactionState;
        $message2=$request->message;
        $referenceCode=$request->referenceCode;
        $reference_pol=$request->reference_pol;
        $transactionId=$request->transactionId;
        $description=$request->description;
        $trazabilityCode=$request->trazabilityCode;
        $cus=$request->cus;
        $orderLanguage=$request->orderLanguage;
        $extra1=$request->extra1;
        $extra2=$request->extra2;
        $extra3=$request->extra3;
        $polTransactionState=$request->polTransactionState;
        $signature=$request->signature;
        $polResponseCode=$request->polResponseCode;
        $lapResponseCode=$request->lapResponseCode;
        $risk=$request->risk;
        $polPaymentMethod=$request->polPaymentMethod;
        $lapPaymentMethod=$request->lapPaymentMethod;
        $polPaymentMethodType=$request->polPaymentMethodType;
        $lapPaymentMethodType=$request->lapPaymentMethodType;
        $installmentsNumber=$request->installmentsNumber;
        $TX_VALUE=$request->TX_VALUE;
        $TX_TAX=$request->TX_TAX;
        $currency=$request->currency;
        $lng=$request->lng;
        $pseCycle=$request->pseCycle;
        $buyerEmail=$request->buyerEmail;
        $pseBank=$request->pseBank;
        $pseReference1=$request->pseReference1;
        $pseReference2=$request->pseReference2;
        $pseReference3=$request->pseReference3;
        $authorizationCode=$request->authorizationCode;

        $TX_ADMINISTRATIVE_FEE=$request->TX_ADMINISTRATIVE_FEE;
        $TX_TAX_ADMINISTRATIVE_FEE=$request->TX_TAX_ADMINISTRATIVE_FEE;
        $TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE=$request->TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE;
        $processingDate = $request->processingDate;

        $amount = round($TX_VALUE, 1,PHP_ROUND_HALF_EVEN); // 10;

        $explota = explode(".",$amount);

        if (empty($explota[1])){
            $amount2 = $explota[0].".0";
        }
        if (Auth::user()){
            $user_id = Auth::user()->id;

            $orderIdSession = 0;
            //ApiKey~merchantId~referenceCode~new_value~currency~transactionState
            //$signature2 = md5($API_key."~".$merchantId."~".$referenceCode."~".$amount2."~".$currency."~".$transactionState);
            $signature2 = md5(env('KEY_PAY')."~".env('MERCHANT')."~".$referenceCode."~".$amount2."~".$currency."~".$transactionState);
            
            if ($signature == $signature2){
                //ESTADOD E LA TRANSACCION 4 es APPROVED - 6 es RECHAZADA o DECLINADA - 5 es EXPIRADA - 7 es PENDING - 104 es ERROR


                if ($transactionState == 4){
                    $orderIdSession = session()->get('myorder');
                    session()->forget(['cart', 'myorder', 'codehash']);
                    $approval = 1;
                    $message = "Su tranacción ha sido aprobada!!";
                }else if($transactionState == 6){
                    $approval = 0;
                    switch ($polResponseCode) {
                        case '4':
                            $message = "Transacción rechazada por entidad financiera!!";
                            break;
                        case '5':
                            $message = "Transacción rechazada por el banco!!";
                            break;
                        case '6':
                            $message = "Fondos insuficientes!!";
                            break;
                        case '7':
                            $message = "Tarjeta inválida!!";
                            break;
                        case '8':
                            $message = "Débito automático no permitido. Contactar entidad financiera!!";
                            break;
                        case '9':
                            $message = "Tarjeta vencida!!";
                            break;
                        case '10':
                            $message = "Tarjeta restringida!!";
                            break;
                        case '12':
                            $message = "Fecha de expiración o código de seguridadinválidos!!";
                            break;
                        case '13':
                            $message = "Reintentar pago!!";
                            break;
                        case '14':
                            $message = "Transacción inválida!!";
                            break;
                        case '17':
                            $message = "El valor excede el máximo permitido por la entidad!!";
                            break;
                        case '19':
                            $message = "Transacción abandonada por el pagador!!";
                            break;
                        case '22':
                            $message = "Tarjeta no autorizada para comprar por internet!!";
                            break;
                        case '23':
                            $message = "Transacción rechazada por sospecha de fraude!!";
                            break;
                        case '9995':
                            $message = "Certificado digital no encontrado!! Comunicate con servicioalcliente@leemon.com.co";
                            break;
                        case '9996':
                            $message = "Error tratando de cominicarse con el banco!!";
                            break;
                    }
                    
                }else if($transactionState == 5){
                    $approval = 0;
                    $message = "Transacción expirada!!";
                    
                }else if($transactionState == 7){
                    $approval = 7;
                    $message = "Transacción pendiente!!";
                
                }else if($transactionState == 104){
                    $approval = 0;
                    $message = "Se presentó un Error en la Trasacción en la plataforma de Pay-U!!";
                    
                }
            
            }else{
                $approval = 0;
                $message = "Se presentó Problemas en la Transacción";	
            }

            $member = Member::select('firstname', 'lastname', 'email', 'n_doc')->where('user_id', $user_id)->first();
            $dataTransaction = ["processingDate" => $processingDate, "referenceCode" => $referenceCode, "description" => $description, "total" => $TX_VALUE, "origen" => $lapPaymentMethodType." - ".$lapPaymentMethod, "reference" => $reference_pol, "name" => $member->firstname." ".$member->lastname, "email" => $member->email, "n_doc" => $member->n_doc];

        }else{
            $approval = 0;
            $message = "Esta información ya ha sido procesada y entregada";
            $dataTransaction = "error";
        }

       
        $url = json_encode($dataTransaction,TRUE);
        $lru = $orderIdSession."~".$url;
        $url2 = base64_encode($lru);

        return view('confirmPurchasePayU', [
            'approval' => $approval,
            'message' => $message,
            'response' => $dataTransaction,
            'url' => $url2,
        ]);

    }

    //---------------------------------------------------------------------------------------------------------
    //
    //---------------------------------------------------------------------------------------------------------
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

// merchantId=508029
// merchant_name=Test+PayU+Test+comercio
// merchant_address=Av+123+Calle+12
// telephone=7512354
// merchant_url=http%3A%2F%2Fpruebaslapv.xtrweb.com
// transactionState=4
// lapTransactionState=APPROVED
// message=APPROVED
// referenceCode=100498-61
// reference_pol=1400140964
// transactionId=5da86e45-e80f-4d31-910d-0883001b3adf
// description=Pay-U%3A+Compra+de+Productos+Naturales
// trazabilityCode=approved
// cus=approved
// orderLanguage=es
// extra1=
// extra2=
// extra3=
// polTransactionState=4
// signature=8376636ea895cd484f12fe41e287b866
// polResponseCode=1
// lapResponseCode=APPROVED
// risk=
// polPaymentMethod=10
// lapPaymentMethod=VISA
// polPaymentMethodType=2
// lapPaymentMethodType=CREDIT_CARD
// installmentsNumber=1
// TX_VALUE=223900.00
// TX_TAX=.00
// currency=COP
// lng=es
// pseCycle=
// buyerEmail=hab.borge%40gmail.com
// pseBank=
// pseReference1=
// pseReference2=
// pseReference3=
// authorizationCode=553419
// TX_ADMINISTRATIVE_FEE=.00
// TX_TAX_ADMINISTRATIVE_FEE=.00
// TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE=.00
// processingDate=2021-03-25