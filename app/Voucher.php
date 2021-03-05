<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Auth;

class Voucher extends Model
{
    protected $fillable = [
        'voucher','type','user_id','amount','discount','hash','descr','start_in','end_in','status','created','used'
    ];

    public function updateVoucher($voucher_id){

        $now = new \DateTime();
        $today = $now->format('Y-m-d H:i:s');

        $voucher = Voucher::find($voucher_id);
        $voucher->user_id = Auth::user()->id;
        $voucher->used = $today;
        $voucher->status = "used";
        $rv = $voucher->save();

        return $rv;
    }
}
