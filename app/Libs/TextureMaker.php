<?php
namespace App\Libs;


function rgb($img, $x, $y): array
{
    $color = imagecolorat($img, $x, $y);
    $color = imagecolorsforindex($img, $color);
    $color = [$color['red'],$color['green'],$color['blue']];
    return $color;
}

function randomize_colors($img){
    $factors = [];
    if(mt_rand(0,1)){
        $factors['red'] = mt_rand(1,255);
    }
    if(mt_rand(0,1)){
        $factors['green'] = mt_rand(1,255);
    }
    if(mt_rand(0,1)){
        $factors['blue'] = mt_rand(1,255);
    }
    $w = imagesx($img);
    $h = imagesy($img);
    for($x=0;$x<$w;$x++){
        for($y=0;$y<$h;$y++){
            $index = imagecolorat($img, $x, $y);
            $color = imagecolorsforindex($img, $index);
            foreach($color as $k => $v){
                if(isset($factors[$k])){
                    $color[$k] = ($v * $factors[$k]) % 255;
                }
            }
            imagesetpixel($img,$x,$y,imagecolorallocate($img,$color['red'],$color['green'],$color['blue']));
        }
    }
}

function clone_and_flip($image, $mode){
    $w = imagesx($image);
    $h = imagesy($image);
    $clone = imagecrop($image, [
        'x'=>0,'width'=>$w,'y'=>0,'height'=>$h
    ]);
    imageflip($clone, $mode);
    return $clone;
}


function clone_and_darken($image, $factor=.4){

    $w = imagesx($image);
    $h = imagesy($image);

    $clone = imagecrop($image, [
        'x'=>0,'width'=>$w,'y'=>0,'height'=>$h
    ]);

    for($x=0;$x<$w;$x++){
        for($y=0;$y<$h;$y++){
            $index = imagecolorat($clone, $x, $y);
            $color = imagecolorsforindex($clone, $index);
            $color = array_map(function($v) use($factor){ return $v * $factor; },$color);
            imagesetpixel($clone,$x,$y,imagecolorallocate($clone,$color['red'],$color['green'],$color['blue']));
        }
    }

    return $clone;

}

function make_texture($tl, $tr, $bl, $br){
    $canvas = imagecreatetruecolor(50, 50);
    imagecopy($canvas,$tl,0,0,0,0,25,25);
    imagecopy($canvas,$tr,25,0,0,0,25,25);
    imagecopy($canvas,$bl,0,25,0,0,25,25);
    imagecopy($canvas,$br,25,25,0,0,25,25);
    return $canvas;
}

class TextureMaker{

    public $in_glob;
    public $out_width = 25;
    public $out_height = 25;

    function __construct($in_glob = "*.jpg", $out_width = 25, $out_height = 25){
        $this->in_glob = $in_glob;
        $this->out_width = $out_width;
        $this->out_height = $out_height;
    }

    function seed(){
        $seed = crc32(uniqid());
        srand($seed);
        return $seed;
    }

    function makeBlock(){

        $seed = $this->seed();

        $files = glob($this->in_glob, GLOB_BRACE);
        $f = $files[array_rand($files)];

        $img = imagecreatefromjpeg($f);

        $w = imagesx($img);
        $h = imagesy($img);

        $half_w = $this->out_width / 2;
        $half_h = $this->out_height / 2;

        $rect = [
            'x' => mt_rand(0, $w - $half_w),
            'width' => $half_w,
            'y' => mt_rand(0, $h - $half_h),
            'height' => $half_h
        ];

        $cropped = imagecrop($img,$rect);

        if(mt_rand(0,1)){
            randomize_colors($cropped);
        }

        if(mt_rand(0,1)){
            imageflip($cropped, mt_rand(1,3));
        }

        if(mt_rand(0,1)){
            $cropped = imagerotate($cropped, 90 * mt_rand(1,3),0);
        }

        $cropped = clone_and_darken($cropped,mt_rand(4,7)/10);

        $tl = $cropped;

        $tr = clone_and_flip($cropped,IMG_FLIP_HORIZONTAL);
        $bl = clone_and_flip($cropped,IMG_FLIP_VERTICAL);
        $br = clone_and_flip($bl,IMG_FLIP_HORIZONTAL);

        $t = make_texture($tl, $tr, $bl, $br);
        imagejpeg($t, $f = "/tmp/$seed.jpg");
        imagedestroy($t);
        return $f;
    }

    function makeBlockAndSpace(){

        $seed = $this->seed();

        $block = imagecreatefromjpeg($bf = $this->makeBlock());
        $space = clone_and_darken($block,mt_rand(2,4)/10);

        if(mt_rand(0,1)){
            $space = imagerotate($space,90,0);
        }

        imagejpeg($space, $sf = "/tmp/$seed.jpg");
        imagedestroy($space);
        imagedestroy($block);

        return [$bf, $sf];

    }

}
