<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function checkout(){
        $total_item = Cart::where('customer_id', Auth::guard('customerlogin')->id())->count();
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();
        return view('frontend.checkout', [
            'total_item'=>$total_item,
            'carts'=>$carts,
            'countries'=>$countries,
        ]);
    }

    function getCity(Request $request){

        $cities = City::where('country_id', $request->country_id)->get();
        $str = '<option value="">-- Select city --</option>';

        foreach($cities as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function checkout_store(Request $request){

        if($request->payment_method == 1){
        //Orders
        $order_id = '#'.Str::upper(Str::random(3)).'-'.rand(99999999, 10000000);
        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'sub_total'=>$request->sub_total,
            'total'=>$request->sub_total + $request->charge,
            'discount'=>$request->discount,
            'charge'=>$request->charge,
            'payment_method'=>$request->payment_method,
            'created_at'=>Carbon::now(),
        ]);

        //billing
        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'name'=>$request->name,
            'email'=>$request->email,
            'company'=>$request->company,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'zip'=>$request->zip,
            'notes'=>$request->notes,
            'created_at'=>Carbon::now(),
        ]);

        //Order Product
        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'product_id'=>$cart->product_id,
                'price'=>$cart->rel_to_product->after_discount,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);

            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
        }

        //Invoice Send to Mail
        Mail::to($request->email)->send(new InvoiceMail($order_id));

        //sms
        $url = "https://bulksmsbd.net/api/smsapi";
        $api_key = "GCB8erOmA2uAXmz7AGkr";
        $senderid = "touhid";
        $number = $request->mobile;
        $message = "test sms check";

        $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $number,
        "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);



        //clear  cart after order
        // Cart::where('customer_id', Auth::guard('customerlogin')->id())->delete();
        $abc = substr($order_id, 1,13);
        return redirect()->route('order.success', $abc)->with('success', 'ada');
        }

        else if($request->payment_method == 2){
            $data = $request->all();
            return redirect()->route('pay')->with('data', $data);
        }
        else{
            $data = $request->all();
            return view('frontend.stripe', [
                'data'=>$data,
            ]);
        }

    }

    function order_success($abc){
        if(session('success')){
            return view('frontend.order_success', [
                'order_id'=>$abc,
            ]);
        }
        else{
            abort(404);
        }

    }

}
