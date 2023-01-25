<?php

namespace App\Libs;

class RoomMaker{

    public $width;
    public $height;
    public $block_char;
    public $space_char;

    function __construct(int $width, int $height, $block_char = 'x', $space_char=' '){
        $this->width = $width;
        $this->height = $height;
        $this->block_char = $block_char;
        $this->space_char = $space_char;
    }

    function make(){
        $struct = [];
        for($y=0;$y<$this->height;$y++){
            $struct[] = array_fill(0, $this->width, $this->block_char);
        }
        $num_cells = $this->width * $this->height;
        $cnt_spaces = 0;
        $max_spaces = $num_cells / mt_rand(2,8);
        while($cnt_spaces < $max_spaces){
            $x = rand(1,$this->width-1);
            $y = rand(1,$this->height-1);
            $step_x = rand(0,1) ? 1 : -1;
            $step_y = rand(0,1) ? 1 : -1;
            while($x < $this->width-1 && $y < $this->height-1 && $x > 1 && $y > 1){
                if($struct[$y][$x]==$this->block_char){
                    $struct[$y][$x] = $this->space_char;
                    $cnt_spaces++;
                }
                if(rand(0,1)){
                    $y += $step_y;
                } else {
                    $x += $step_x;
                }
            }
        }
        return new RoomMakerStruct($struct, $this);
    }

}

class RoomMakerStruct{

    public $struct = [];
    public $block_char = 'x';

    function __construct(array $struct, RoomMaker $maker){
        $this->struct = $struct;
        $this->block_char = $maker->block_char;
        $this->space_char = $maker->space_char;
    }

    function isBlock($y, $x){
        return isset($this->struct[$y][$x])
            && $this->struct[$y][$x] == $this->block_char;
    }

    function beautify(){
        for($i=1;$i<=10;$i++){
            $changes = 0;
            foreach($this->struct as $y => $line){
                foreach($line as $x => $cell){
                    // remove blocks surrounded by spaces
                    if($this->isBlock($y, $x)
                        && !$this->isBlock($y-1, $x)
                        && !$this->isBlock($y+1, $x)
                        && !$this->isBlock($y, $x-1)
                        && !$this->isBlock($y, $x+1)
                    ){
                        $this->struct[$y][$x] = $this->space_char;
                        $changes++;
                    }
                    // remove spaces surrounded by blocks
                    if(!$this->isBlock($y, $x)
                        && $this->isBlock($y-1, $x)
                        && $this->isBlock($y+1, $x)
                        && $this->isBlock($y, $x-1)
                        && $this->isBlock($y, $x+1)
                    ){
                        $this->struct[$y][$x] = $this->block_char;
                        $changes++;
                    }
                    // xxxxx           xxxxx
                    // xx  x  Becomes  xxx x
                    //   xxx             xxx
                    //
                    if($this->isBlock($y, $x)){
                        if(
                            $this->isBlock($y-1, $x+1)
                            && !$this->isBlock($y, $x+1)
                            && !$this->isBlock($y-1, $x)
                        ){
                            $struct[$y][$x+1] = $this->block_char;
                            $changes++;
                        }
                        if(
                            $this->isBlock($y-1, $x-1)
                            && !$this->isBlock($y, $x-1)
                            && !$this->isBlock($y-1, $x)
                        ){
                            $struct[$y][$x-1] = $this->block_char;
                            $changes++;
                        }
                    }
                }
            }
            if(!$changes) break;
        }
        return $this;
    }

    function __toString(){
        $lines = [];
        foreach($this->struct as $line){
            $lines[] = implode($line);
        }
        return implode("\n",$lines);
    }
}
