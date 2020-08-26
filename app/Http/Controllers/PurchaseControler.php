<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Http\Requests\StoreMembers;
use Image;

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
        // create Image from file
        $file = $request->imgname;
        $texto = $request->texto;
        $originalPath = public_path().'/img/';
        $img = Image::make('img/'.$file)->resize(300, 300);


        // write text at position
        $img->text($texto, 20, 150, function($font) {
            $font->file('css/Roboto-Regular.ttf');
            $font->size(12);
            $font->color('#000000');
        });

        // save the file in png format
        $id = Auth::user()->id;
        $img->save('img/'.$id.'.png');
        dd($img);
    }
}
