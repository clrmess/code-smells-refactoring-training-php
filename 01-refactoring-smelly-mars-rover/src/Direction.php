<?php

namespace App;

abstract class Direction
{

    public static function create(string $direction)
    {
        if($direction === "N") {
            return self::North();
        }

        if($direction === "S") {
            return self::South();
        }

        if($direction === "W") {
            return self::West();
        }

        return self::East();
    }

    protected static function North(): North
    {
        return new North();
    }

    protected static function South(): South
    {
        return new South();
    }

    protected static function West(): West
    {
        return new West();
    }

    protected static function East(): East
    {
        return new East();
    }

    abstract public function rotateLeft(): Direction;

    abstract public function rotateRight() :Direction;

    abstract public function move($displacement, $coordinates): Coordinates;
}