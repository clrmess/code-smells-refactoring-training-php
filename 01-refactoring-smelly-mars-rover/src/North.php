<?php

namespace App;

class North extends Direction
{
    public function rotateLeft(): Direction
    {
        return self::West();
    }

    public function rotateRight(): Direction
    {
        return self::East();
    }

    public function move($displacement, $coordinates): Coordinates
    {
        return $coordinates->moveAlongY($displacement);
    }


}