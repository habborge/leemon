<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Member;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\ReCaptchaRule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CART;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ndoc' => ['required', 'unique:members,n_doc'],
            'birthday' => ['required'],
            'phone' => ['required', 'numeric'],
            'recaptcha_token' => ['required', new   ReCaptchaRule($data['recaptcha_token'])]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $firstname = strtolower($data['name']);
        $lastname = strtolower($data['lastname']);

        $email = strtolower($data['email']);
        
        $user = User::create([
            'name' => $firstname." ".$lastname,
            'email' => $email,
            'password' => Hash::make($data['password']),
            'code_verify' => null,
            'email_verified' => 0
        ]);

        $newDate = date("Y-m-d", strtotime($data['birthday']));

        $member = Member::create([
            'user_id' => $user->id, 
            'email' => $email, 
            'firstname' => $firstname,
            'lastname' => $lastname,
            'n_doc' => $data['ndoc'],
            'birthday' => $newDate,
            'phone' => "+".$data['callingcode']."-".$data['phone'],
            'address' => '', 
            'delivery_address' => '', 
            'city' => '', 
            'dpt' => '', 
            'country' => '', 
            'status' => 1
        ]);

        return $user;
    }
}
