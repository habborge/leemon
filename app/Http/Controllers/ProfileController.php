<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;

class ProfileController extends Controller
{
    public function myOrders(){

        $user_id = Auth::user()->id;

        $orders = Order::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(20);

        return view('profile.myOrders',[
            'orders' => $orders
        ]);

    }
}
