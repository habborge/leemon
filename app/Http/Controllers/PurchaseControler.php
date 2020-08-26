<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Http\Requests\StoreMembers;

class PurchaseControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //--------------------------------------------------------------------------------------------------------------    
    //
    //--------------------------------------------------------------------------------------------------------------
    public function purchase(){
        $infosaved = 0;
        $id = Auth::user()->id;
        
        $info = Member::where('user_id', $id)->first();

        if ($info){
            $infosaved = 1;
        }
        
        return view('purchase', [
            'infosaved' => $infosaved,
            'info' => $info
        ]);
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
        public function addInfoUser(StoreMembers $request){
            $user_info = New Member();
            
            $rs = $user_info->set($request);

            if($rs){
                return redirect('cart')->with('success', 'Usuario creado de manera Exitosa!!');
            }else{
                return back()->with('notice', 'Un error ha ocurrido!!');
            }
        }
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function confirm()
    {
        return view('confirm');
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function generateimg(Request $request)
    {
        dd($request);
    }
}
