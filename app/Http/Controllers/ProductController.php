<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Thumbnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.addproduct', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function getSubcategory(Request $request){
        $subcategories =  Subcategory::where('category_id', $request->category_id)->get();
        $str = '<option value="">-- Select SubCategory --</option>';
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

    function product_store(Request $request){
        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - ($request->price*$request->discount/100),
            'brand'=>$request->brand,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'long_desp'=>$request->long_desp,
            'slug'=>Str::lower(str_replace(' ', '-', $request->product_name)).'-'.rand(0, 1000000000000),
        ]);

        $preview_image = $request->preview;

        $extension = $preview_image->getClientOriginalExtension();
        $file_name = Str::random(3).rand(100,999).'.'.$extension;
        Image::make($preview_image)->resize(450,450)->save(public_path('uploads/product/preview/'.$file_name));

        Product::find($product_id)->update([
            'preview'=>$file_name,
        ]);

        foreach($request->thumbnail as $thumbnail){
            $extension = $thumbnail->getClientOriginalExtension();
            $file_name =  Str::random(3).rand(100,999).'.'.$extension;
            Image::make($thumbnail)->resize(450,450)->save(public_path('uploads/product/thumbnail/'.$file_name));
            Thumbnail::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);
        }

        return back();
    }

    function product_list(){
        $products = Product::all();
        return view('admin.product.product', [
            'products'=>$products,
        ]);
    }

    function inventory($product_id){
        $colors = Color::all();
        $sizes = Size::all();
        $product_info = Product::find($product_id);
        $inventories = Inventory::where('product_id',$product_id)->get();
        return view('admin.product.inventory',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product_info'=>$product_info,
            'inventories'=>$inventories,
        ]);
    }
    function inventory_store(Request $request){
        Inventory::insert([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
        ]);
        return back();
    }
    function variation(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.variation', [
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }
    function variation_store(Request $request){

        if($request->btn == 1){
            Color::insert([
                'color_name'=>$request->color_name,
                'color_code'=>$request->color_code,
            ]);
            return back();
        }
        else{
            Size::insert([
                'size_name'=>$request->size_name,
            ]);
            return back();
            }
        }

        function product_delete($product_id){
            $delete_preview = Product::where('id', $product_id)->first()->preview;
            $delete_from_preview = public_path('uploads/product/preview/'.$delete_preview);
            unlink($delete_from_preview);

            $thumbnails = Thumbnail::where('product_id', $product_id)->get();
            foreach($thumbnails as $thum){
                $delete_thum = Thumbnail::where('id', $thum->id)->first()->thumbnail;
                $delete_from_thum = public_path('uploads/product/thumbnail/'.$delete_thum);
                unlink($delete_from_thum);
                Thumbnail::find($thum->id)->delete();
            }
            Product::find($product_id)->delete();
            return back();
        }

}
