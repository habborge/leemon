<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Order;
use App\payment_error;
use Symfony\Component\Console\Output\ConsoleOutput;

class VerifyZonaPagos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
        ---------------------------------------------------------------------------------------------
        int_estado_pago ($data_info[4]) - Este valor es el estado en el que se encuentra la transacción:
        ---------------------------------------------------------------------------------------------
        200: Pago iniciado
        777: Pago declinado
        888: Pago pendiente por iniciar
        999: Pago pendiente por finalizar
        4001: Pendiente por CR
        4000: Rechazado CR
        4003: Error CR
        1000: Pago rechazado
        1001: Error entre ACH y el Banco. (Rechazada)
        1002: Pago rechazado
        1: Pago finalizado Ok
        ---------------------------------------------------------------------------------------------
        

        -------------------------------
        int_id_forma_pago ($data_info[20])
        -------------------------------
        29: PSE
        32: Tarjeta de Crédito
        41: PDF generado en ZonaPAGOS
        42: Gana
        45: Tarjeta Tuya
        -------------------------------
        */
        /* 
        --------------------------------------------------------------
        - if int_id_forma_pago = 29 then                             -
        --------------------------------------------------------------
        $data_info[21] = str_ticketID 18092100031 |
        $data_info[22] = int_codigo_servicio 2701 |
        $data_info[23] = int_codigo_banco 1022 | 
        $data_info[24] = str_nombre_banco BANCO UNION COLOMBIANO | 
        $data_info[25] = str_codigo_transacción 1468228 | 
        $data_info[26] = int_ciclo_transacción 3 |
        --------------------------------------------------------------

        --------------------------------------------------------------
        - if int_id_forma_pago = 32 then                             -
        --------------------------------------------------------------
        $data_info[21] = str_ticketID 18092100031 |
        $data_info[22] = int_numero_tarjeta  2701 |
        $data_info[23] = str_franquicia  Diners Club, American Express, Visa, Master Card | 
        $data_info[24] = int_cod_aprobacion  56844 | 
        $data_info[26] = int_num_recibido  4532211566 |
        --------------------------------------------------------------

        ; 31 | 3773 | 1 | 1 | 1 | 12500 | 12500 | 13 | camisa | 123456789 | Cristina | Vargas | 319632555648 | soporte9@zonavirtual.com | opcion 11 | opcion 12 | opcion 13 | | | 9/11/2018 12:58:41 PM | 29 | 18092100031 | 2701 | 1022 | BANCO UNION COLOMBIANO | 1468228 | 3 |;"
        */
        /*
            $data_info[0] = int_ped_numero 31 | 
            $data_info[1] = int_n_pago 3772 | 
            $data_info[2] = int_pago_parcial 1|  
            $data_info[3] = int_pago_terminado 200 |
            $data_info[4] = int_estado_pago 1002 | 
            $data_info[5] = dbl_valor_pagado 12500 | 
            $data_info[6] = dbl_total_pago 12500 |
            $data_info[7] = dbl_valor_iva_pagado 13 |
            $data_info[8] = str_descripcion camisa |
            $data_info[9] = str_id_cliente 123456789 |
            $data_info[10] = str_nombre Cristina |
            $data_info[11] = str_apellido Vargas |
            $data_info[12] = str_telefono 319632555648 |
            $data_info[13] = str_email soporte9@zonavirtual.com |
            $data_info[14] = str_campo1 str_opcional1 |
            $data_info[15] = str_campo2 str_opcional2 |
            $data_info[16] = str_campo3 str_opcional3 |
            $data_info[17] = str_campo4 str_opcional4 |
            $data_info[18] = str_campo5 str_opcional5 |
            $data_info[19] = dat_fecha 9/11/2018 12:58:41 PM |
            $data_info[20] = int_id_forma_pago 29 | 
        */

        $ordersPre = Order::where('status', 'Open')->orWhere('status', 'Processing');

        $info = "";
        if ($ordersPre->exists()){
            $orders = $ordersPre->get();
        
            foreach ($orders as $order) {
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

                            $result = $this->verifyInfo($info);
                            $data_info = $result[3];
                            // array($approval, $sw, $message); if sw = 1
                            if ($result[1] == 1){

                                $insertData = $this->insertInfoError($order, $response, $data_info);

                                if ($insertData[1]){
                                    // array($approval, $sw, $message);
                                    if ($result[0] == 1){
                                        $order_change = Order::approval_order($order->id);
                                    }else{
                                        // int_pago_terminado => 1: Terminado => 2: Pendiente: En caso de que el pago sea mixto. El pago no ha sido terminado en su totalidad. => 200 Pago iniciado
                                        if ($data_info[3] == 1){
                                            $order_change = Order::reject_order($order->id);
                                        }
                                    
                                    }
                                }
                                
                        
                            }else{
                                $insertData = $this->insertInfoError($order, $response, $data_info);
                                if ($insertData[1]){
                                    // array($approval, $sw, $message); var approval is 1 transaction was approved, if var approval is 0 was rejected
                                    if ($result[0] == 2){
                                        $order_change = Order::pending_order($order->id);
                                        // $order_status = 2;
                                    }
                                }
                            }

                        }else if ($response->json()['int_cantidad_pagos'] > 1){
                            $info = explode(";", $response->json()['str_res_pago']);
                            // $output = new ConsoleOutput();
                            // $output->writeln("<info>Converting".$response->json()['str_res_pago']."</info>");

                            $order_status = 0;
                            for ($i=0; $i < count($info) -1; $i++) { 
                                $result = [];
                                $result = $this->verifyInfo($info[$i]);
                                $data_info = $result[3];
                                
                                // array($approval, $sw, $message); if sw = 1 transaction was approved or reject
                                if ($result[1] == 1){

                                    $insertData = $this->insertInfoError($order, $response, $data_info);
                                    
                                    // if insert works
                                    if ($insertData[1]){
                                        // array($approval, $sw, $message); var approval is 1 transaction was approved, if var approval is 0 was rejected
                                        if ($result[0] == 1){
                                            $order_change = Order::approval_order($order->id);
                                            $order_status = 1;
                                            break;
                                        }else{
                                            //$order_change = Order::reject_order($order->id);
                                            $order_status = 0;
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
                        // $order_change = Order::reject_order($order->id);

                        $rs = new payment_error();
                        $rs->reference_code = $order->reference_code;
                        $rs->user_id = $order->user_id;
                        $rs->order_id = $order->id;
                        $rs->description = "100498-".$order->id."~".$response;
                        $rs->save(); 
                    }
                }
            }
        }else{

        }
    }
    
    private function verifyInfo($info){
        
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
                    $message = "En este momento su Número de Referencia o Factura (100498-) presenta un proceso de pago cuya
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
                    $message = "En este momento su Numero de Referencia o Factura (100498-) presenta un proceso de pago cuya
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
}
