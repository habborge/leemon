<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Address;
use Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $addresses = Address::where('user_id', $user_id)->orderBy('default', 'desc')->paginate(12);

        return view('profile.addresses', [
            'addresses' => $addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.newaddress',[

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
            'city'  => 'required', 
            'dpt' => 'required',  
            'country' => 'required',  
            'zipcode' => 'required',
            'contact' => 'required',
            'phone' => 'required|numeric|digits_between:7,12',
        ];

        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return view('profile.newaddress', [
                'completeRequest' => $request,
            ])->withErrors($p);
        }else{
            $address = New Address();
            $rs = $address->set($request);

            if($rs){
                return redirect('addresses')->with('success', 'Usuario creado de manera Exitosa!!');
            }else{
                return view('profile.newaddress', [
                    'completeRequest' => $request,
                ])->withErrors($p);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::find($id);

        return view('profile.editaddress',[
            'completeRequest' => $address,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
            'city'  => 'required', 
            'dpt' => 'required',  
            'country' => 'required',  
            'zipcode' => 'required',
            'contact' => 'required',
            'phone' => 'required|numeric|digits_between:7,12',
        ];

        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return view('profile.editaddress', [
                'completeRequest' => $request,
            ])->withErrors($p);
        }else{
            $address = Address::find($id);
            $address->address = $request->address_1."~".$request->address_2."~".$request->address_3."~".$request->address_4;
            $address->country = $request->country;
            $address->dpt = $request->dpt;
            $address->city = $request->city;
            $address->zipcode = $request->zipcode;
            $address->phone = $request->phone;
            $address->contact = $request->contact;
            $address->details = $request->details;
            $rs = $address->save();

            if($rs){
                return redirect('addresses')->with('success', 'Dirección actualizada manera Exitosa!!');
            }else{
                return view('profile.editaddress', [
                    'completeRequest' => $request,
                ])->withErrors($p);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function default($id){
        
        $preview = Address::where('user_id', Auth::user()->id)->where('default', 1)->first();
        $preview->default = 0;
        $preview->save();

        $address = Address::find($id);
        $address->default = 1;
        $rs = $rs = $address->save();

        if($rs){
            return redirect('addresses')->with('success', 'Dirección actualizada manera Exitosa!!');
        }else{
            return redirect('addresses')->withErrors('error', 'No se pudo actualizar la dirección por defecto!!');
        }
    }
}
