<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    function index(){
        return view('login');
    }

    function store(Request $r){
        if(!auth()->attempt($r->only(['email','password']))){
            return back()->with('error','invalid credentials');
        }
        return redirect('/');
    }
}
