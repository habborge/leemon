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
        $orders = Order::where('status', 'Open')->get();

        foreach ($orders as $order) {
            $data = [
                    "int_id_comercio" => 30364,
                    "str_usuario" => "Leemon",
                    "str_clave" => env('ZV_PA'),
                    "str_id_pago" => "100498-".$order->id,
                    "int_no_pago" => 1
            ];

            $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/VerificacionPago', $data);

            if ($response->json()['int_estado'] == 1){
                if ($response->json()['int_estado'] == 0){
                    if ($response->json()['int_cantidad_pagos'] == 1){
                        $info = $response->json()['str_res_pago'];

                       

                    }else if ($response->json()['int_cantidad_pagos'] > 1){
                        $info = explode(";", $response->json()['str_res_pago']);

                    }
                    // {
                    //     "int_estado": 1,
                    //     "int_error": 0,
                    //     "str_detalle": null,
                    //     "int_cantidad_pagos": 2,
                    //     "str_res_pago": "|3772 | | 200 | 1002 | | 12500 | | | 123456789 | Cristina | Vargas | 319632555648 | soporte9@zonavirtual.com | opcion 11 | opcion 12 | opcion 13 | | | | | ; 31 | 3773 | 1 | 1 | 1 | 12500 | 12500 | 13 | camisa | 123456789 | Cristina | Vargas | 319632555648 | soporte9@zonavirtual.com | opcion 11 | opcion 12 | opcion 13 | | | 9/11/2018 12:58:41 PM | 29 | 18092100031 | 2701 | 1022 | BANCO UNION COLOMBIANO | 1468228 | 3 |;"
                    //   }
                }else{
                    payment_error::insertarError($response);
                }
            }

            $rs = new payment_error();
            $rs->reference_code = "fdfdfd";
            $rs->order_id = 12;
            $rs->description = $info;
            $rs->save();
        }
        //return 0;
    }
}
