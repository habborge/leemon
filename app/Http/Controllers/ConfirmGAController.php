<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendPurchaseGA;
use App\Order;
use App\Voucher;
use App\Member;
use Mail;
use Auth;

class ConfirmGAController extends Controller
{
    public function BackToCommerce(Request $request){

        if (session()->get('myorder')){
            $orderIdSession = session()->get('myorder');
            $voucher_info = session()->get('vouchergiveaway');

            $user_id = Auth::user()->id;

            $voucher_hash = md5(env('SECRETPASS')."~".$voucher_info["voucher_id"]."~0~".$voucher_info["voucher_type"]."~".$voucher_info["voucher_amount"]);

            if ($voucher_hash == $voucher_info["voucher_hash"]){
                $voucher_id = $voucher_info["voucher_id"];

                $order = Order::where('id', $orderIdSession)
                ->where('voucher_id', $voucher_id);
                
                if ($order->exists()){
                    $dataorder = $order->first();

                    $voucher = Voucher::find($voucher_id);

                    if ($voucher->type = $voucher_info["voucher_type"]){
                        $voucher->status = "used";
                        $voucher->save();
                    }

                    $dataorder->status = "Approved";
                    $dataorder->status_after_approved = "stock";
                    $dataorder->save();

                }


            }
            session()->forget(['cart', 'myorder', 'codehash', 'vouchergiveaway']);

            $member = Member::select('firstname', 'lastname', 'email', 'n_doc')->where('user_id', $user_id)->first();
            $sending = Mail::to($member->email)->bcc(env('MAIL_BCC_ADDRESS'))->send(new SendPurchaseGA($dataorder, $member));

            $approval = 1;
            $message = "Su tranacción ha sido aprobada!!";

           

        }else{
            $approval = 0;
            $message = "Se presentó Problemas en la Transacción de Voucher";
        }

        return view('confirmPurchaseGA', [
            'approval' => $approval,
            'message' => $message,
        ]);
    }
}
