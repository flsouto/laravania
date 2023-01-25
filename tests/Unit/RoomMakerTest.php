<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Libs\RoomMaker;

class RoomMakerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_room_maker()
    {
        $rm = new RoomMaker(100, 100, 'x', ' ');
        $struct = $rm->make()->beautify();
        die("$struct");
    }
}
