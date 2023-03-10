<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $tm = app(\App\Libs\TextureMaker::class);
        [$block_f, $space_f] = $tm->makeBlockAndSpace();
        $base_sf = basename($space_f);
        $base_bf = basename($block_f);
        $d = Storage::disk('public');
        $d->putFileAs('/', new File($block_f), $base_bf);
        $d->putFileAs('/', new File($space_f), $base_sf);

        $rm = app(\App\Libs\RoomMaker::class,[
            'width' => 50, 'height' => 50
        ]);
        $struct = $rm->make()->beautify()->__toString();
        return [
            'name' => $this->faker->city(),
            'struct' => $struct,
            'width' => 14,
            'height' => 3,
            'space_img' => $base_sf,
            'block_img' => $base_bf
        ];
    }
}
