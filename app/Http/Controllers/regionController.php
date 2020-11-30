<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Department;
use App\City;
class regionController extends Controller
{
    public function dpt(Request $request){
        $country_id = $request->id;

        $dpts = Department::where('country_id', $country_id)->orderBy('department', 'ASC')->get();

        //dd($dpts[0]->id);
        return response()->json(['status'=>200, 'dpts' =>$dpts]);

    }

    public function city(Request $request){
        $dpt_id = $request->id;

        $cities = City::where('dpt_d', $dpt_id)->orderBy('city_d_id', 'ASC')->get();

        //dd($dpts[0]->id);
        return response()->json(['status'=>200, 'city' =>$cities]);

    }
}
