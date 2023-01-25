<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Signup extends Controller
{
    function index(){
        return view('signup');
    }

    function store(Request $r){
        $this->validate($r, [
            'name' => 'required|min:4',
            'email' => 'email|required|unique:users',
            'password' => 'min:3|confirmed'
        ]);
        $id = \User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => \Hash::make($r->password)
        ]);
        return redirect('login')->with('success','Signup successfull');
    }
}
