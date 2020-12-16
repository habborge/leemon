<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Order;
use App\payment_error;

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

        $orders = Order::where('status', 'Open')->get();
        $info = "";
        foreach ($orders as $order) {
            $data = [
                    "int_id_comercio" => env('ZV_ID'),
                    "str_usr_comercio" => env('ZV_CO'),
                    "str_pwd_comercio" => env('ZV_PA'),
                    "str_id_pago" => "100498-".$order->id,
                    "int_no_pago" => 1
            ];

            $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/VerificacionPago', $data);

            // if int_estado = 1 then API ran good
            if ($response->json()['int_estado'] == 1){ 

                // if int_error = 0 then API found payments
                if ($response->json()['int_error'] == 0){

                    if ($response->json()['int_cantidad_pagos'] == 1){
                        
                        $info = $response->json()['str_res_pago'];
                        $data_info = explode("|", $info);



                    }else if ($response->json()['int_cantidad_pagos'] > 1){
                        $info = explode(";", $response->json()['str_res_pago']);
                    }
                    
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
                }else{
                   // payment_error::insertarError($response);
                }
            }

            $rs = new payment_error();
            $rs->reference_code = $order->reference_code;
            $rs->order_id = $order->id;
            $rs->description = "100498-".$order->id."~".$response;
            $rs->save(); 
        }
        
        
        //return 0;
    }
}
