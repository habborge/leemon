<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Creditcard;
use Auth;

class CreditCardController extends Controller
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
        $cards = Creditcard::where('user_id', $user_id)->orderBy('default', 'desc')->paginate(12);

        return view('profile.methods', [
            'cards' => $cards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('profile.newCard', [

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
        $user_id = Auth::user()->id;

        $rules = [
            'cc_name' => 'required|string',
            'cc_number' => 'required|string|min:15|max:20',
            'cc_expiration_m' => 'required|string|min:2|max:2',
            'cc_expiration_y' => 'required|string|min:2|max:2',
            'cc_cvv' => 'required|string|min:3|max:4'
        ];

        $p = Validator::make($request->all(), $rules);

        if ($p->fails()){
            return view('profile.newCard', [
                'completeRequest' => $request,
            ])->withErrors($p);
        }else{

            $res = $this->luhnCheck($request->cc_number);

            if ($res == true){

                $card_info = New Creditcard();
                $rs = $card_info->set($request);

                if($rs){
                    return redirect('/methods')->with('success', 'Usuario creado de manera Exitosa!!');
                }else{
                    return back()->with('notice', 'Un error ha ocurrido!!');
                }
            }else{
                $error = ['notice' => 'Número de tarjeta inexistente!!'];
                return view('profile.newCard', [
                    'completeRequest' => $request,
                ])->withErrors($error);     
            }
            //return response()->json(['status'=>200]);
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
        //
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
        //
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

    //--------------------------------------------------------------------------------------------------------------
        //
        //--------------------------------------------------------------------------------------------------------------
        private function luhnCheck($number) {

            // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
            $number=preg_replace('/\D/', '', $number);
          
            // Set the string length and parity
            $number_length=strlen($number);
            $parity=$number_length % 2;
          
            // Loop through each digit and do the maths
            $total=0;
            for ($i=0; $i<$number_length; $i++) {
              $digit=$number[$i];
              // Multiply alternate digits by two
              if ($i % 2 == $parity) {
                $digit*=2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                  $digit-=9;
                }
              }
              // Total up the digits
              $total+=$digit;
            }
          
            // If the total mod 10 equals 0, the number is valid
            return ($total % 10 == 0) ? TRUE : FALSE;
          
        }

        public function creditCardList(){
            
            $cards = Creditcard::where('user_id', Auth::user()->id)->orderBy('default', 'desc')->get();
        
            $html="";
            foreach ($cards as $card)
            {
                if ($card->default == 1){
                    $html.= "<div class='alert alert-success info-small' role='alert'>Tarjeta ".$card->brand." Terminada en ************".$card->last4num."<br>Caduca: ".$card->expiration."<br>Nombre: ".$card->fullname."</div>";

                }else{
                $html.= "<div class='alert alert-secondary info-small' role='alert'>
                            <div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-8'>
                                        <div class='row'>
                                            <p>Tarjeta ".$card->brand." Terminada en ************".$card->last4num."<br>Caduca: ".$card->expiration."<br>Nombre: ".$card->fullname."</p>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class='row float-right'>
                                
                                            <button id='' class='btn btn-dark btn-sm select-add' data-id='".$card->id."' onclick='changeCard(".$card->id.")'>Seleccionar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        }

        return response()->json(['status'=>200,'info'=>$html]);
        }

        public function creditCardChange(Request $request){
            $user_id = Auth::user()->id;

            $data = Creditcard::find($request->id);

        if ($user_id == $data->user_id){
            $preview = Creditcard::where('user_id', Auth::user()->id)->where('default', 1)->first();

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
