<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(){
        return view('back-end.profile');
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_pass' => 'required',
            'new_pass' => 'required',
            'c_password' => 'required|same:new_pass',
        ]);

        
        Session()->flash('change-password');
        
        if($validator->passes()){
            $current_pass = $request->current_pass;
            $user = User::find(Auth::user()->id);
            if(password_verify($current_pass, $user->password)){
                $user->password = Hash::make($request->new_pass);
                $user->save();
                return redirect()->back()->with('success', 'Password changed successfully');
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

    }

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . Auth::user()->id],
        ]);

        Session()->flash('update-profile');

        if($validator->passes()){
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            return redirect()->back()->with('success', 'Profile updated successfully');
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    public function changeProfileImage(Request $request){
        Session()->flash('change-profile-image');

        if($request->hasFile('image')){     
           $image = $request->file('image');
           $name = rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('uploads/temp'), $name);

           $user = User::find(Auth::user()->id);
           $user->image = $name;
           $user->save();
           return response()->json([
                'status' => 200,
                'message' => 'Image uploaded successfully',
                'image' => $name
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Image upload failed'
            ]);
        }
    }
}
