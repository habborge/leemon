<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
   public function paymentProcess(Request $request){
       
    $response = Http::post('https://www.zonapagos.com/Apis_CicloPago/api/InicioPago',[
        "InformacionPago" => [
            "flt_total_con_iva" => 83000,
            "flt_valor_iva" => 833,
            "str_id_pago" => "180924",
            "str_descripcion_pago" => "camisa",
            "str_email" => "soporte9@zonavirtual.com",
            "str_id_cliente" => "123456789",
            "str_tipo_id" => "1",
            "str_nombre_cliente" => "Elsa",
            "str_apellido_cliente" => "Pito",
            "str_telefono_cliente" => "319632555648",
            "str_opcional1" => "opcion 11",
            "str_opcional2" => "opcion 12",
            "str_opcional3" => "opcion 13",
            "str_opcional4" => "opcion 14",
            "str_opcional5" => "opcion 15"
        ],
        "InformacionSeguridad" => [
            "int_id_comercio" => 30364,
            "str_usuario" => "Leemon",
            "str_clave" => "Leemon30364*",
            "int_modalidad" =>  1
        ],
        "AdicionalesPago" => [

        ]
    ]);

    dd($response->json());

   }
}
