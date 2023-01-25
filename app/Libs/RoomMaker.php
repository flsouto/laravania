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
        while($cnt_spaces < $num_cells / 3){
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
        foreach($this->struct as $y => $line){
            foreach($line as $x => $cell){
                if($this->isBlock($y, $x)
                    && !$this->isBlock($y-1, $x)
                    && !$this->isBlock($y+1, $x)
                    && !$this->isBlock($y, $x-1)
                    && !$this->isBlock($y, $x+1)
                ){
                    $this->struct[$y][$x] = $this->space_char;
                }
                if(!$this->isBlock($y, $x)
                    && $this->isBlock($y-1, $x)
                    && $this->isBlock($y+1, $x)
                    && $this->isBlock($y, $x-1)
                    && $this->isBlock($y, $x+1)
                ){
                    $this->struct[$y][$x] = $this->block_char;
                }

            }
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
