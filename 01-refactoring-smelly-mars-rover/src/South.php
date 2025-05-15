<?php

namespace App;

class South extends Direction
{



    public function rotateLeft(): Direction
    {
        return self::East();

    }

    public function rotateRight(): Direction
    {
        return  self::West();
    }

    public function move($displacement, $coordinates): Coordinates
    {
        return $coordinates->moveAlongY(- $displacement);
    }


}