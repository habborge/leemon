<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Http\Requests\StoreMembers;
use Image;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Order_detail;
use PDF;
use Mail;
use App\Mail\OrderShipped;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PurchaseControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function verifyInsert($request){
        
        $rules = [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            
            'address_1' => 'required',
            'address_2' => 'required',
            'address_3' => 'required',
            'address_4' => 'required',
            'city'  => 'required', 
            'dpt' => 'required',  
            'country' => 'required',  
            'n_doc' => 'required',
            'cc_name' => 'required|string',
            'cc_number' => 'required|string|min:15|max:20',
            'cc_expiration_m' => 'required|string|min:2|max:2',
            'cc_expiration_y' => 'required|string|min:2|max:2',
            'cc_cvv' => 'required|string|min:3|max:4'
        ];

        if (!isset($request->sameaddress)){
            
            $rules['address_1b'] = 'required';
            $rules['address_2b'] = 'required';
            $rules['address_3b'] = 'required';
            $rules['address_4b'] = 'required';
            $rules['city_e'] = 'required';
            $rules['dpt_e'] = 'required'; 
            $rules['country_e'] = 'required'; 
        }
        
        return $p = Validator::make($request->all(), $rules);
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
        public function addInfoUser(Request $request){
            
            
            $infosaved = 0;
            $id = Auth::user()->id;
            $p = $this->verifyInsert($request);
            $info = Member::where('user_id', $id)->first();
    
            if ($info){
                $infosaved = 1;
            }
            
            if ($p->fails()){
                return view('purchase', [
                    'completeRequest' => $request,
                    'infosaved' => $infosaved,
                    'info' => $info,
                    'checkbox' => $request->sameaddress
                ])->withErrors($p);
            }else{
                $res = $this->luhnCheck($request->cc_number);

                if ($res == true){

                    $user_info = New Member();
                    $rs = $user_info->set($request);
    
                    if($rs){
                        return redirect('cart')->with('success', 'Usuario creado de manera Exitosa!!');
                    }else{
                        return back()->with('notice', 'Un error ha ocurrido!!');
                    }
                }else{
                    $error = ['notice' => 'Número de tarjeta inexistente!!'];
                    return view('purchase', [
                        'completeRequest' => $request,
                        'infosaved' => $infosaved,
                        'info' => $info,
                        'checkbox' => $request->sameaddress,
                        
                    ])->withErrors($error);     
                }
                
            }
           
        }

        //--------------------------------------------------------------------------------------------------------------
        //
        //--------------------------------------------------------------------------------------------------------------
        public function luhnCheck($number) {

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
    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function confirm()
    {
        // $valor_almacenado = session('cart');
        // dd($valor_almacenado);
        return view('confirm');
    }

    //--------------------------------------------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------------------------------------------
    public function generateimg(Request $request)
    {
        //bring product array from cart
        $valor_almacenado = session('cart');

        $new_array = array_values($valor_almacenado);
        // dd($new_array[0]['name']);
        //sql member info
        $id = Auth::user()->id;
        $query = DB::table('members as m')
        ->select('m.email as email', 'm.firstname','m.lastname','m.address', 'm.delivery_address', 'm.city', 'm.dpt', 'm.country', 'm.n_doc', 'c.fullname','c.cardnumber', 'c.expiration', 'c.cvv')
        ->join('creditcards as c', 'm.user_id', '=', 'c.user_id' )
        ->where('m.user_id', $id)->get();

        //new class to insert new order
        $new_order = New Order();

        //call function in Order model
        $rs = $new_order->insert($query[0]);

        if($rs[0]){
            //$order_id=$rs->id;
            $new_details = New Order_detail();
            $ds = $new_details->insert($rs[1], $new_array);
            
        }else{
            return back()->with('notice', 'Un error ha ocurrido!!');
        }

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
        $img->save('img/'.$rs[1].'.png');

        // bring order info
        $order_info = Order::find($rs[1]);

        
        $data = array($order_info, $new_array);
        //dd($data);
        //generar pdf
        $pdf = PDF::loadView('extends.order', compact('data'))->save('orders/order_'.$rs[1].'.pdf');

        $sending = $this->send($rs[1], $query[0]);
        //dd($sending);
        if ($sending){
            return redirect('thanks')->with('success', 'Usuario creado de manera Exitosa!!');
        }else{

        }
    }

    public function send($order_id, $member){

        $email = Auth::user()->email;
        $mem_id = Auth::user()->id;

        $customer = $member->firstname." ".$member->lastname;

        $customer2 = "CLIENTE: ".$member->firstname." ".$member->lastname." \n"."DIRECCION DE ENTREGA: ".$member->delivery_address." \n"."EMAIL: ".$member->email." \n"."DOCUMENTO: ".$member->n_doc." \n"."TARJETA No: ".$member->cardnumber." \n"."VENCIMIENTO: ".$member->expiration;
       
        //Example
        File::put('orders/member_'.$mem_id.'.txt',$customer2);
        
        $sending = Mail::to($email)->send(new OrderShipped($customer, $order_id));

        return true;
        // Mail::send('emails.Recovery_InventCloud', $data, function($message) use ($data) {
		// 	$message->from('no-reply@inventcloud.com', 'InventCloud');
		// 	$message->to($data['email'],$data['email'])->subject('Recuperación de Contraseña');
		// });
    }
}
