<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\SendToFriend;
use App\Member;
use Mail;
use Auth;

class SendingEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendToFriend(Request $request){

        $rules = [
            'email' => 'required|string|email|max:255'
        ];
        
        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return response()->json(['status'=>403, 'El email no es Valido']);
        }else{
            $member = Member::select(DB::raw('CONCAT(firstname, lastname) AS fullname'))->where('user_id', Auth::user()->id)->first();
            
            $sending = Mail::to($request->email)->send(new SendToFriend($request->id, $request->proName, $request->img, $member->fullname));
        }
    }
}
