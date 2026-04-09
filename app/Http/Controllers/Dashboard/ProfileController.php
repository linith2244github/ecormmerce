<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(){
        $user = User::find(Auth::user()->id);
        $contacts = Contact::where('user_id', Auth::user()->id)->get();
        $userAddress = UserAddress::where('user_id', Auth::user()->id)->first();
        return view('back-end.profile', [
            'user' => $user,
            'contacts' => $contacts,
            'address' => $userAddress,
        ]);
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

            if(!empty($request->image_name)){
                $imageName = $request->image_name;
                $image_path = public_path('uploads/temp/' . $imageName);
                $user_path = public_path('uploads/user/' . $imageName);

                if(File::exists($image_path)){
                    File::copy($image_path, $user_path);
                    File::delete($image_path);
                }

                $user->image = $imageName;
            }
            $user->save();
            
            $findContact = Contact::where('user_id', Auth::user()->id)->first();
            if($findContact != null){
                //Update
                $allContact = Contact::where('user_id', Auth::user()->id)->get();
                $links = $request->link;
                for($i = 0; $i < count($allContact); $i++){
                    $allContact[$i]->contact_url = $links[$i];
                    $allContact[$i]->save();
                }
            }else{
                //Insert
                $links = $request->link;
                /*
                "link" => array:2 [
                    0 => "https://www.facebook.com/",
                    1 => "https://www.twitter.com/",
                    2 => "https://www.linkedin.com/",
                    .....
                ]
                 */
                for($i = 0; $i < count($links); $i++){
                    $contact = new Contact();
                    $contact->user_id = Auth::user()->id;
                    $contact->contact_url = $links[$i];
                    $contact->save();
                }
            }

            // Address Update or create start
            $findAddress = UserAddress::where('user_id', Auth::user()->id)->first();
            if($findAddress != null){
                //Update
                $findAddress->address = $request->address;
                $findAddress->save();
            }else{
                //Insert
                $address = new UserAddress();
                $address->user_id = Auth::user()->id;
                $address->address = $request->address;
                $address->save();
            }

            // Address Update or crate end

            return redirect()->back()->with('success', 'Profile updated successfully');
        }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    public function changeProfileImage(Request $request){
        Session()->flash('change-profile-image');

        if($request->hasFile('image')){     
           $image = $request->file('image');
           $name = time() . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('uploads/temp'), $name);

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
