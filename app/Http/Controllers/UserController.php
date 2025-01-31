<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show User's Create Form
    public function create(){
        return view("users.register");
    }

    public function store(Request $request){
        $formsField=$request->validate([
            "name"=> "required|min:3",
            "email"=> ["required","email",Rule::unique('Users','email')],
            'password'=> "required|min:6|confirmed",
        ]);

        //Hash Password
        $formsField['password']= bcrypt($formsField['password']);

        $user = User::create($formsField);
        
        auth('web')->login($user) ;

        return redirect('/')->with('success','User Created and logged in!');

    }

    //log out user

    public function logout(Request $request){
        auth('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success','You have been logged out');
    }


    //Log in User
    public function login(){
        return view('users.login');
    }

    //Authenticate User
    public function authenticate(Request $request){
        $formsField=$request->validate([
            "email"=> ["required","email"],
            'password'=> "required",
        ]);

        if(auth("web")->attempt($formsField)){
            $request->session()->regenerate();
            return redirect("/")->with("success","You have been logged in!");
        }else{
            return back()->withErrors(["email"=> "Invalid Credentials!"])->onlyInput("email");
        }
    }
}
