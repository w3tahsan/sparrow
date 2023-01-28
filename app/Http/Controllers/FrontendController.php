<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Size;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Arr;

class FrontendController extends Controller
{
    function index()
    {

        //cookie
        $recent_viewed_product = json_decode(Cookie::get('recent_view'), true);
        if ($recent_viewed_product == NULL) {
            $recent_viewed_product = [];
            $after_unique = array_unique($recent_viewed_product);
        } else {
            $after_unique = array_unique($recent_viewed_product);
        }
        $recent_viewed_product = Product::find($after_unique);
        $categories = Category::all();
        $products = Product::all();
        $best_selling_product = OrderProduct::groupBy('product_id')
            ->selectRaw('sum(quantity) as sum, product_id')
            ->orderBy('quantity', 'DESC')
            ->havingRaw('sum >= 5')
            ->get();

        return view('frontend.index', [
            'categories' => $categories,
            'products' => $products,
            'best_selling_product' => $best_selling_product,
            'recent_viewed_product' => $recent_viewed_product,
        ]);
    }

    function categories_product($category_id)
    {
        $category_name = Category::find($category_id);
        $category_products = Product::where('category_id', $category_id)->get();
        return view('frontend.category_product', [
            'category_products' => $category_products,
            'category_name' => $category_name,
        ]);
    }

    function details($slug)
    {

        $product_info = Product::where('slug', $slug)->get();
        $related_products = Product::where('category_id', $product_info->first()->category_id)->where('id', '!=', $product_info->first()->id)->get();
        $thumbnails = Thumbnail::where('product_id', $product_info->first()->id)->get();
        $available_colors = Inventory::where('product_id', $product_info->first()->id)
            ->groupBy('color_id')
            ->selectRaw('count(*) as total, color_id')->get();
        $sizes = Size::all();
        $reviews = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->sum('star');

        //cookies
        $product_id = $product_info->first()->id;
        $al = Cookie::get('recent_view');
        if (!$al) {
            $al = "[]";
        }
        $all_info = json_decode($al, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);
        Cookie::queue('recent_view', $recent_product_id, 1000);


        return view('frontend.details', [
            'product_info' => $product_info,
            'thumbnails' => $thumbnails,
            'available_colors' => $available_colors,
            'sizes' => $sizes,
            'related_products' => $related_products,
            'reviews' => $reviews,
            'total_review' => $total_review,
            'total_star' => $total_star,
        ]);
    }

    function getSize(Request $request)
    {
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();

        $str = '';
        foreach ($sizes as $size) {
            $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                        <input class="form-check-input" ' . ($size->rel_to_size->id == 1 ? "checked" : "") . ' type="radio" name="size_id" id="' . $size->rel_to_size->id . '" value="' . $size->rel_to_size->id . '">
                        <label class="form-option-label" for="' . $size->rel_to_size->id . '">' . $size->rel_to_size->size_name . '</label>
                    </div>';
        }
        echo $str;
    }

    function customer_register_login()
    {
        return view('frontend.customer_reg_log');
    }

    function cart(Request $request)
    {
        $coupon = $request->coupon;
        $message = null;
        $type = '';

        if ($coupon == '') {
            $discount = 0;
        } else {
            if (Coupon::where('coupon_name', $coupon)->exists()) {
                if (Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon)->first()->expire) {
                    $discount = 0;
                    $message = 'Coupon Code Expired';
                } else {
                    $discount = Coupon::where('coupon_name', $coupon)->first()->discount;
                    $type = Coupon::where('coupon_name', $coupon)->first()->type;
                }
            } else {
                $discount = 0;
                $message = 'Invalid Coupon Code';
            }
        }


        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts' => $carts,
            'discount' => $discount,
            'message' => $message,
            'type' => $type,
        ]);
    }


    function review_store(Request $request)
    {
        OrderProduct::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->update([
            'review' => $request->review,
            'star' => $request->star,
        ]);
        return back();
    }
}
