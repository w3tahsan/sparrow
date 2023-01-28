<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CustomPaginateController extends Controller
{
    function custom_paginate(){
        $all_products = Product::paginate(4);
        return view('frontend.product', [
            'all_products'=>$all_products,
        ]);
    }
}
