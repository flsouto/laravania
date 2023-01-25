<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Database\Factories\RoomFactory;
use Illuminate\Support\Facades\URL;
use App\Libs\TextureMaker;

class Room extends Controller
{
    function create(RoomFactory $f, TextureMaker $tm){
        $t = base64_encode(file_get_contents($tm->makeBlock()));
        return view('rooms.create', [
            'room' => $f->definition(),
            'player' => $t
        ]);
    }
}
