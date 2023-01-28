<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::all();
        return view('admin.orders.orders', [
            'orders'=>$orders,
        ]);
    }

    function order_status(Request $request){
        $after_explode = explode(',', $request->status);
        Order::where('order_id', $after_explode[0])->update([
            'status'=>$after_explode[1],
        ]);
        return back();
    }
}
