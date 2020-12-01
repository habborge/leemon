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
    // "id" => 17305
    //       "user_id" => 2
    //       "address" => "Clle~43~no~34 - 45"
    //       "country" => "47"
    //       "dpt" => "5"
    //       "city" => "17305"
    //       "zipcode" => "54545454"
    //       "phone" => ""
    //       "contact" => "juan esteban perez garcia"
    //       "details" => "casa blanca de rejas negras"
    //       "default" => 1
    //       "created_at" => "2020-11-29 19:27:52"
    //       "updated_at" => "2020-11-29 19:27:52"
    //       "country_master_id" => 47
    //       "country_master_name" => "Colombia"
    //       "country_master_sig" => "CO"
    //       "country_flag" => "Colombia.png"
    //       "code" => 5
    //       "continent_id" => 1
    //       "language" => "es"
    //       "department" => "ANTIOQUIA"
    //       "country_id" => 47
    //       "dane_o" => "8001000"
    //       "city__o_id" => "BARRANQUILLA"
    //       "dpt_o" => "ATLANTICO"
    //       "dane_d" => "5021000"
    //       "city_d_id" => "ALEJANDRIA"
    //       "dpt_d" => "5"
    //       "type_pack" => "RX"
    //       "cost_pack" => 1886
    //       "type_mess" => "O"
    //       "cost_m_1k" => 15300
    //       "cost_m_2k" => 19550
    //       "cost_m_3k" => 24550
    //       "cost_m_4k" => 29250
    //       "cost_m_5k" => 34050
    public function index()
    {
        $user_id = Auth::user()->id;
        $addresses = Address::select('addresses.id as addressId', 'addresses.address', 'addresses.zipcode', 'addresses.contact', 'addresses.details', 'c.country_master_name', 'd.department', 'ct.city_d_id')->where('user_id', $user_id)
            ->join('countries as c', 'c.country_master_id', 'addresses.country')
            ->join('departments as d', 'd.code', 'addresses.dpt')
            ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
            ->orderBy('default', 'desc')->paginate(12);
           
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
        $address = Address::select('addresses.id as addressId', 'addresses.address', 'addresses.zipcode', 'addresses.contact', 'addresses.details', 'c.country_master_id as countryId', 'c.country_master_name as country', 'd.code', 'd.department', 'ct.id as cityId', 'ct.city_d_id')
        ->where('addresses.id', $id)
        ->join('countries as c', 'c.country_master_id', 'addresses.country')
        ->join('departments as d', 'd.code', 'addresses.dpt')
        ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
        ->first();
//dd($address);
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
            return back()->withInput()->withErrors($p);
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

    public function addressList(){
        $addresses = Address::select('addresses.id as addressId', 'addresses.address', 'addresses.zipcode', 'addresses.contact', 'addresses.details', 'addresses.default', 'c.country_master_name', 'd.department', 'ct.city_d_id')->where('user_id', Auth::user()->id)
        ->join('countries as c', 'c.country_master_id', 'addresses.country')
        ->join('departments as d', 'd.code', 'addresses.dpt')
        ->join('cost_tcc as ct', 'ct.id', 'addresses.city')
        ->orderBy('default', 'desc')->get();
        
        $html="";
        foreach ($addresses as $address)
		{
            if ($address->default == 1){
                $html.= "<div class='alert alert-success info-small' role='alert'>".$address->contact."<br>".$address->address.", ".$address->zipcode." Código Postal<br>";
                if ($address->details){ 
                    $html.= ucwords($address->details)."<br>"; 
                }
                $html.= ucwords($address->city_d_id)." (".ucwords($address->department)."), ".ucwords($address->country_master_name)."</div>";

            }else{
                $html.= "<div class='alert alert-secondary info-small' role='alert'>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-8'>
                                        <div class='row'>
                                            <p>".$address->contact."<br>".$address->address.", ".$address->zipcode." Código Postal<br>";
                                            if ($address->details){ 
                                                $html.= ucwords($address->details)."<br>"; 
                                            }
                                                $html.= ucwords($address->city_d_id)." (".ucwords($address->department)."), ".ucwords($address->country_master_name)."
                                            </p>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class='row float-right'>
                                
                                            <button id='' class='btn btn-dark btn-sm select-add' data-id='".$address->addressId."' onclick='changeAddress(".$address->addressId.")'>Seleccionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        }

        return response()->json(['status'=>200,'info'=>$html]);

    }

    public function addressChange(Request $request){
        $user_id = Auth::user()->id;

        $data = Address::find($request->id);

        if ($user_id == $data->user_id){
            $preview = Address::where('user_id', Auth::user()->id)->where('default', 1)->first();

            $preview->default = 0;
            $preview->save();

            $data->default = 1;
            $rs = $rs = $data->save();

            if($rs){
                return response()->json(['status'=>200]);
            }else{
                return response()->json(['status'=>500]);
            }
        }else{
            return response()->json(['status'=>520]);
        }
        
    }
}
