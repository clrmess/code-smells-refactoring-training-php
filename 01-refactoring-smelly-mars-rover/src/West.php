<?php

namespace App;

class West extends Direction
{



    public function rotateLeft(): Direction
    {
        return self::South();
    }

    public function rotateRight(): Direction
    {
        return  self::North();
    }

    public function move($displacement, $coordinates): Coordinates
    {
        return $coordinates->moveAlongX(- $displacement);
    }


}