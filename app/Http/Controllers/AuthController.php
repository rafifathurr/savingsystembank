<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index(){
        return view('auth.signin');
    }

    public function signup(){
        return view('auth.signup');
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('home.index');
        }else{
            return back()->with(["error" => "Invalid Credentials!"])->onlyInput('email');
        }
    }

    public function register(Request $request){

        $datenow = date('Y-m-d H:i:s');
        $credentials = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required',
			'c_password' => 'required',
        ]);

        $check_email = User::where('email',$request->email)->first();
        $check_phone = User::where('phone',$request->phone)->first();

        if(is_null($check_email) && is_null($check_phone)){
            if($request->password == $request->c_password){
                $create = User::create([
                    'name' => $request->name,
                    'email'=> $request->email,
                    'phone' => $request->phone,
                    'password'=> bcrypt($request->password),
                ]);
                if($create){

                    $customer = Customer::create([
                        'accountId' => mt_rand(),
                        'id_user' => $create->id,
                        'name' => $request->name,
                        'created_at' => $datenow
                    ]);

                    if($customer){

                        return redirect()->route('signin.index')->with(["success" => "Register Successfully!"]);

                    }else{

                        return back()->with(["error" => "Error Create!"]);

                    }

                }else{

                    return back()->with(["error" => "Error Create!"]);

                }
            }else{

                return back()->with(["error" => "Password Not Match!"]);

            }
        }else{

            return back()->with(["error" => "Account Already Exist!"]);

        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('signin.index');
    }

}
