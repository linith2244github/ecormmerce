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
        if(Auth::check()){
            if(Auth::user()->role == 1){
                return redirect()->route('dashboard.index');
            }else{
                return redirect()->route('category.index');
            }
        }else{
            return view('back-end.login');
        }
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
                }elseif(Auth::user()->role == 2){
                    return redirect()->route('category.index')->with('success', 'Login  Successfully!');
                }
            }else{
                return redirect()->back()->withInput()->with(['error' => 'Invalid Email or Password!']);
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.index');
    }
}
