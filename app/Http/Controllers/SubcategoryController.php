<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Image;
use Str;

class SubcategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.subcategory', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }
    function subcategory_store(Request $request){
        $id = Subcategory::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
        ]);

        $subcategory_image = $request->subcategory_img;
        $extension = $subcategory_image->getClientOriginalExtension();
        $file_name = Str::random(3).rand(100,999).'.'.$extension;
        $img = Image::make($subcategory_image)->resize(300,250)->save(public_path('uploads/subcategory/'.$file_name));

        Subcategory::find($id)->update([
            'subcategory_img'=>$file_name,
        ]);

       return back()->with('success', 'SubCategory Added Succfully!');
    }


    function edit_subcategory($subcategory_id){
        $categories = Category::all();
        $subcategory_info = Subcategory::find($subcategory_id);
        return view('admin.subcategory.edit', [
            'subcategory_info'=>$subcategory_info,
            'categories'=>$categories,
        ]);
    }

    function update_subcategory(Request $request){
        if($request->subcategory_img == ''){
            Subcategory::find($request->id)->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
            ]);
            return back()->with('success', 'SubCategory Updated Succfully!');
        }
        else{
            $img = Subcategory::where('id', $request->id)->first()->subcategory_img;
            $delete_from = public_path('uploads/subcategory/'.$img);
            unlink($delete_from);

            $uploaded_file = $request->subcategory_img;
            $extension = $uploaded_file->getClientOriginalExtension();
            $file_name = Str::random(3).rand(100,999).'.'.$extension;

            Image::make($uploaded_file)->save(public_path('uploads/subcategory/'.$file_name));

            Subcategory::find($request->id)->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'subcategory_img'=>$file_name,
            ]);

            return back()->with('success', 'SubCategory Updated Succfully!');
        }
    }
}
