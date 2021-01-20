<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use App\Order;
use Auth;

// 501 there is not order id in Orders table
// 502 did not find payments
// 901 APi did not work

trait PurchaseTrait{
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
    public function validatePending($orderId){
        $message = "";
        $sw = 0;
        $approval = 0;

        $user_id = Auth::user()->id;
        $orderIdSession = session()->get('myorder');
        // $orderIdSession = 83;
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

            // if int_estado = 1 then API ran good
            if ($response->json()['int_estado'] == 1){ 

                // if int_error = 0 then API found payments
                if ($response->json()['int_error'] == 0){

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

                    return array(200, $approval, $data_info, $message);
                
                }else{
                    return array(502, $approval);
                }
            }else{
                return array(901, $approval);
            }

        }else{
            return array(501, $approval);
        }



    }
    
}

