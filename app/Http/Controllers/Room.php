<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Database\Factories\RoomFactory;
use Illuminate\Support\Facades\URL;

class Room extends Controller
{
    function create(RoomFactory $f){
        return view('rooms.create', [
            'room' => $f->definition()
        ]);
    }
}
