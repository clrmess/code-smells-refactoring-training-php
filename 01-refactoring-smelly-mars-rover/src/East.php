<?php

namespace App;

class East extends Direction
{


    public function rotateLeft(): Direction
    {
        return self::North();
    }

    public function rotateRight(): Direction
    {
        return self::South();
    }

    public function move($displacement, $coordinates): Coordinates
    {
        return $coordinates->moveAlongX($displacement);
    }


}