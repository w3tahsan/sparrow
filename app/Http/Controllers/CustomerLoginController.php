<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    function customer_login(Request $request)
    {

        if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::guard('customerlogin')->user()->email_verified_at == null) {
                return redirect()->route('customer.reglogin')->with('verifyemail', 'Please verify your email first! check your email for verification link');
            } else {
                return redirect('/');
            }
        } else {
            return redirect()->route('customer.reglogin');
        }
    }
    function customer_logout()
    {
        Auth::guard('customerlogin')->logout();
        return redirect()->route('customer.reglogin');
    }
}
