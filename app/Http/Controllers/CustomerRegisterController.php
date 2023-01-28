<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\CustomerEmailVerifyNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CustomerRegisterController extends Controller
{
    function customer_store(Request $request)
    {
        CustomerLogin::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);

        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $customer_info = CustomerEmailVerify::create([
            'customer_id' => $customer->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($customer_info));

        return back()->withSuccess('We have sent you a verification email! please check your email');
    }
}
