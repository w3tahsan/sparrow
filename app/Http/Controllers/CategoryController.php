<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Str;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function category(){
        $categories = Category::all();
        $trash_categories = Category::onlyTrashed()->get();
        return view('admin.category.category', [
            'categories'=> $categories,
            'trash_categories'=>$trash_categories,
        ]);
    }
    function category_store(Request $request){

       $request->validate([
        'category_name'=>'required',
        'category_img'=>'required|file|max:512|mimes:jpg,bmp,png,gif',
       ],[
            'category_name.required'=>'Category nam de!',
            'category_img.required'=>'Category Image de!',
       ]);

       $id = Category::insertGetId([
            'category_name'=> $request->category_name,
            'icon'=> $request->icon,
            'added_by'=> Auth::id(),
            'created_at'=> Carbon::now(),
       ]);

        $category_image = $request->category_img;
        $extension = $category_image->getClientOriginalExtension();
        $file_name = Str::random(3).rand(100,999).'.'.$extension;
        $img = Image::make($category_image)->resize(300,250)->save(public_path('uploads/category/'.$file_name));

        Category::find($id)->update([
            'category_img'=>$file_name,
        ]);

       return back()->with('success', 'Category Added Succfully!');

    }

    function category_delete($category_id){
        Category::find($category_id)->delete();
        return back();
    }
    function category_hard_delete($category_id){
        $image = Category::onlyTrashed()->where('id', $category_id)->first()->category_img;
        $delete_from = public_path('uploads/category/'.$image);
        unlink($delete_from);

        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back();
    }

    function category_edit($category_id){
        $catrgory_info = Category::find($category_id);
        return view('admin.category.edit', [
            'catrgory_info'=>$catrgory_info,
        ]);
    }
    function category_update(Request $request){
        if($request->category_img == ''){
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
            ]);
            return back();
        }
        else{

            $image = Category::where('id', $request->category_id)->first()->category_img;
            $delete_from = public_path('uploads/category/'.$image);
            unlink($delete_from);

           $category_image = $request->category_img;
           $extension = $category_image->getClientOriginalExtension();
           $file_name = Str::random(3).rand(100,999).'.'.$extension;
           $img = Image::make($category_image)->resize(300,250)->save(public_path('uploads/category/'.$file_name));

           Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
                'category_img'=>$file_name,
            ]);
            return back();

        }
    }

    function restore_category($category_id){
       Category::onlyTrashed()->find($category_id)->restore();
       return back();
    }



}
