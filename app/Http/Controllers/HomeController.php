<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function users(){
        $users = User::where('id', '!=', Auth::id())->get();
        $total_user = User::count();
        return view('admin.users.user', compact('users', 'total_user'));
    }

    function user_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('success', 'User Deleted!');
    }

    function profile(){
        return view('admin.users.profile');
    }
    function profile_update(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back();
    }

    function password_update(Request $request){

        $request->validate([
            'old_password'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]);

        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('success', 'Password Updated');
        }
        else{
            return back()->with('faild', 'Wrong Old Password');
        }
    }

    function photo_update(Request $request){

        $photo = Auth::user()->photo;
        if($photo == null){
            $uploaded_photo = $request->photo;
            $extension = $uploaded_photo->getClientOriginalExtension();
            $file_name = Auth::id().'.'.$extension;

            Image::make($uploaded_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back();
        }
        else{

            $delete_from = public_path('uploads/user/'.$photo);
            unlink($delete_from);

            $uploaded_photo = $request->photo;
            $extension = $uploaded_photo->getClientOriginalExtension();
            $file_name = Auth::id().'.'.$extension;

            Image::make($uploaded_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(Auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back();
        }
    }


}
