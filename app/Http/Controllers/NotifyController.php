<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotifyAvailability;
use Auth;

class NotifyController extends Controller
{
    public function NotifyProduct(Request $request){
        
        $sw = 0;
        if ($request->t == 0){
            $userEmail = $request->email;
            $sw = 1;
        }else if ($request->t == 1){
            $userEmail = Auth::user()->email;
            $sw = 1;
        }

        if ($sw == 1){
            $new_notify = New NotifyAvailability();
            $ds = $new_notify->insert($request->product_id, $userEmail, $request->t);
        }
        

    }
}
