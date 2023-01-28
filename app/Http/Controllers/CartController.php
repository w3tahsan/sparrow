<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function add_cart(Request $request){

        if(Auth::guard('customerlogin')->id()){
            $request->validate([
                'color_id'=>'required',
                'size_id'=>'required',
                'quantity'=>'required',
            ]);

            $quantity = Inventory::where('product_id', $request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->first()->quantity;

            if($quantity >= $request->quantity){
                if(Cart::where('product_id', $request->product_id)->where('customer_id', Auth::guard('customerlogin')->id())->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
                    Cart::where('product_id', $request->product_id)->where('customer_id', Auth::guard('customerlogin')->id())->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity', $request->quantity);
                    return back()->with('success', 'Cart Updated successfully!');
                }
                else{
                    Cart::insert([
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                    return back()->with('success', 'Cart Added successfully!');
                }

            }
            else{
                return back()->with('stock', 'Out Of Stock, Total Stock:'.$quantity);
            }
        }
        else{
            return redirect()->route('customer.reglogin')->with('login', 'Please Login To Add Cart');
        }
    }

    function cart_remove($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    function cart_update(Request $request){
        $carts = $request->all();
        foreach($carts['quantity'] as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }

}
