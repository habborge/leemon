<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Giveaway;
class GiveawayController extends Controller
{
    public function index(){
        return view('landingPage');
    }

    public function savingData(Request $request){
        $rules = [
            'name' => 'required|string',
            'phone' => 'required|numeric|digits_between:7,12',
            'email' => 'required|email|unique:giveaways,email', 
            'city' => 'required|string|min:2|max:50',
        ];

        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return redirect()->back()->withErrors($p)->withInput();
        }else{
            if (isset($request->terms)){
                $give = New Giveaway();
                $rs = $give->set($request);
    
                if($rs){
                    return redirect('/giveaway/registry')->with('success', 'Gracias por registrarte en el Give Away!!');
                }else{
                   
                }
            }else{
                return redirect()->back()->withErrors("Debe aceptar los Terminos y Condiciones")->withInput();
            }
           
        }
    }
}
