<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\ReCaptchaRule;
use App\Voucher;
use DateTime;

class VoucherController extends Controller
{
    public function voucherVerify(Request $request){

        
        $p =  Validator::make($request->all(), [
            'voucher' => ['required', 'string'],
            'recaptcha_token' => ['required', new ReCaptchaRule($request->recaptcha_token)]
        ]);
        
        if ($p->fails()){
            return response()->json(['status'=>505, 'message' => 'El Voucher debe contener caracteres validos!!']);
        }else{

            $voucher = $request->voucher;
            $voucherInfo = Voucher::where('voucher', $voucher);

            if ($voucherInfo->exists()){
                $info = $voucherInfo->first();
                if ($info->status == "open"){
                    $now = new \DateTime();
                    $today = $now->format('Y-m-d');
                    if (($today >= $info->start_in) and ($today <= $info->end_in)){
                        if ($info->type == 1){

                            $hash = md5(env('SECRETPASS')."~".$info->id."~0~".$info->type);
                            $voucher_array = [
                                'voucher_id' => $info->id,
                                'voucher_cost' => 0,
                                'voucher_type' => 1,
                                'voucher_hash' => $hash
                            ];
                            session()->put('voucher', $voucher_array);
                            return response()->json(['status'=>200, 'message' => 'El Voucher ha sido validado con exito!!']);
                        }
                    }else{
                        if ($today > $info->end_in){
                            
                        }
                    }
                }else{
                    return response()->json(['status'=>506, 'message' => 'El Voucher Ya ha sido usado o no ha sido generado!!']);
                }
            }else{
                return response()->json(['status'=>507, 'message' => 'No puede redimir el Voucher enviado!! Ya fue usado o no existe']);
            }
        }
    }
}
