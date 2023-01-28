<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function search(Request $request)
    {

        // search code
        $data = $request->all();

        $based_on = 'created_at';
        $order = 'DESC';

        if (!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined') {
            if ($data['sort'] == 1) {
                $based_on = 'product_name';
                $order = 'ASC';
            } else if ($data['sort'] == 2) {
                $based_on = 'product_name';
                $order = 'DESC';
            } else if ($data['sort'] == 3) {
                $based_on = 'after_discount';
                $order = 'ASC';
            } else if ($data['sort'] == 4) {
                $based_on = 'after_discount';
                $order = 'DESC';
            } else {
                $based_on = 'created_at';
                $order = 'DESC';
            }
        }

        $all_search_product = Product::where(function ($q) use ($data) {
            if (!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined') {
                $q->where(function ($q) use ($data) {
                    $q->where('product_name', 'like', '%' . $data['q'] . '%');
                    $q->orWhere('long_desp', 'like', '%' . $data['q'] . '%');
                });
            }
            if (!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined') {
                $q->where('category_id', $data['category_id']);
            }
            if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                $q->whereHas('rel_to_inventories', function ($q) use ($data) {
                    if (!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined') {
                        $q->whereHas('rel_to_color', function ($q) use ($data) {
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if (!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined') {
                        $q->whereHas('rel_to_size', function ($q) use ($data) {
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
            if (!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined') {
                $q->whereBetween('after_discount', [$data['min'], $data['max']]);
            }
        })->orderBy($based_on, $order)->get();


        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.search', [
            'all_search_product' => $all_search_product,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }
}
