<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon', [
            'coupons'=>$coupons,
        ]);
    }

    function add_coupon(Request $request){
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'discount'=>$request->discount,
            'expire'=>$request->expire,
            'type'=>$request->type,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
}
