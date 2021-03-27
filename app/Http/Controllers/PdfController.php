<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;

class PdfController extends Controller
{
    public function downloadResponseTrans(Request $request){
        
        $variable =  base64_decode($request->response);
        $lru = explode("~", $variable);
        $order_id = $lru[0];
        $response = json_decode($lru[1],TRUE);

        $pdf = PDF::loadView('extends.transaction', compact('order_id','response'));
        return $pdf->download('Leemontransaction-LNOID-'.$order_id.'.pdf');
        dd($response);
        
    }

    public function downloadResponsePayU(Request $request){
        $variable =  base64_decode($request->response);
        $lru = explode("~", $variable);
        $order_id = $lru[0];
        $response = json_decode($lru[1],TRUE);

        $pdf = PDF::loadView('extends.transactionPayU', compact('order_id','response'));
        return $pdf->download('Leemontransaction-LNOID-'.$order_id.'.pdf');
        dd($response);
        
    }
}
