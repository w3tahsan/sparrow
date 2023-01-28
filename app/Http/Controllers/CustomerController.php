<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Models\CustomerPasswordReset;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\CustomerPasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Facades\Notification;
use PDF;

class CustomerController extends Controller
{
    function customer_profile()
    {
        return view('frontend.customer_profile');
    }
    function customer_profile_update(Request $request)
    {
        if ($request->password == '') {
            if ($request->photo == '') {
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
                return back();
            } else {
                $uploaded_file = $request->photo;
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                Image::make($uploaded_file)->save(public_path('uploads/customer/' . $file_name));

                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'photo' => $file_name,
                ]);
                return back();
            }
        } else {
            if ($request->photo == '') {
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
                return back();
            } else {
                $uploaded_file = $request->photo;
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                Image::make($uploaded_file)->save(public_path('uploads/customer/' . $file_name));

                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'photo' => $file_name,
                ]);
                return back();
            }
        }
    }

    function myorder()
    {
        $myorders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.my_order', [
            'myorders' => $myorders,
        ]);
    }


    function download_invoice($order_id)
    {
        $order_info = Order::find($order_id);
        $billing_info = BillingDetails::where('order_id', $order_info->order_id)->get();
        $order_product = OrderProduct::where('order_id', $order_info->order_id)->get();
        $invoice = PDF::loadView('invoice.download_invoice', [
            'order_info' => $order_info,
            'billing_info' => $billing_info,
            'order_product' => $order_product,
        ]);
        return $invoice->download('invoice.pdf');
    }


    //password reset
    function password_reset_req_form()
    {
        return view('password_reset.password_reset_req_form');
    }

    function password_reset_req_send(Request $request)
    {
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        CustomerPasswordReset::where('customer_id', $customer->id)->delete();

        $customer_info = CustomerPasswordReset::create([
            'customer_id' => $customer->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer, new CustomerPasswordResetNotification($customer_info));
        return back()->with('send_req', 'We have sent you a password request link! please check your email');
    }

    function pass_reset_form($token)
    {
        return view('password_reset.pass_reset_form', [
            'token' => $token,
        ]);
    }

    function pass_reset_confirm(Request $request)
    {
        $customer = CustomerPasswordReset::where('token', $request->token)->firstOrFail();
        CustomerLogin::find($customer->customer_id)->update([
            'password' => bcrypt($request->password),
        ]);
        $customer->delete();
        return back()->with('success', 'Password Reset Successfully');
    }

    function customer_email_verify($token)
    {
        $customer = CustomerEmailVerify::where('token', $token)->firstOrFail();
        CustomerLogin::find($customer->customer_id)->update([
            'email_verified_at' => Carbon::now()->format('Y-m-d'),
        ]);
        return back()->with('verify_success', 'Email Verification Success');
    }
}
