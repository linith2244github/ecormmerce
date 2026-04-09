<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('back-end.login');
    }
    
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                if(Auth::user()->role == 1){
                    return redirect()->route('dashboard.index')->with('success', 'Login  Successfully!');
                }else{
                    return redirect()->back()->with('error', 'Unauthorized Access!');
                }
            }else{
                return redirect()->back()->with('error', 'Invalid Email or Password!');
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.index');
    }
}
