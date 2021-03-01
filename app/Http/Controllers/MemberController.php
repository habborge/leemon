<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;
use App\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Validator;
use DateTime;

class MemberController extends Controller
{
    public function sendEmailVerication(){

        if (Auth::user()){
            $userEmail = Auth::user()->email;
            $emailVerified = Auth::user()->email_verified;
            $emailSendAt = Auth::user()->email_send_at;
            
            
            if($emailVerified == 0){
                $sw = 0;
                $now = new \DateTime();
                $today = $now->format('Y-m-d H:i:s');

                if (!empty($emailSendAt)){
                    $minutes = (strtotime($emailSendAt)-strtotime($today))/60;
                    $minutes = abs($minutes); 
                    //$minutes = floor($minutes);
                    $seconds = ($minutes * 60);
                    
                    if ($seconds > 60){
                        $seconds = 60;
                        $sw = 1;
                    }else{
                        $seconds = 60 - $seconds;
                    }
                }else{
                    $seconds = 1 * 60;
                    $sw = 1;
                }
                
                if ($sw == 1){
                    
                    $random = rand(100000, 9999999);
                    $user = User::where('email', $userEmail)->first();
                    $user->code_verify = $random;
                    $user->email_send_at = $today;
                    $user->save();
                    $sending = Mail::to($userEmail)->send(new VerifyEmail($random));

                }
                
                return view('emailVerify', [
                      'sw'  => $sw,
                      'seconds' => $seconds
                ]);

            }else{
                return redirect('cart');
            }
        }else{
            return redirect('home');
        }
        

        
    }

    public function verifyEmail(Request $request){
       
        
        
        $rules = [
            'code' => 'numeric|required|digits_between:6,8',
        ];

        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return back()->withInput()->withErrors($p);
        }else{
            $user = User::find(Auth::user()->id);
            //dd($user->code_verify,Auth::user()->id);
            if ($user->code_verify == $request->code){

                $now = new \DateTime();
                $today = $now->format('Y-m-d H:i:s');

                $user->email_verified = 1;
                $user->email_verified_at = $today;
                $user->save();

                //return redirect()->back()->with('success', 'Código Verificado');
                return response()->json(['status'=>200,'message'=>'Código Verificado']);

            }else{
                return response()->json(['status'=>540,'message'=>'Código Erroneo']);
                //return back()->with('fail', 'Código Erroneo');
            }
        }
    }
}
