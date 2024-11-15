<?php

namespace helpers;

use App\core\OurDate;
use DateTime;

class OurDateFactory
{
    private const DATE_FORMAT = "Y/m/d";

    public static function create(string $dateAsString): OurDate
    {
        $dateTime = DateTime::createFromFormat(self::DATE_FORMAT, $dateAsString);
        if(!$dateTime){
            throw new \InvalidArgumentException('Wrong date');
        }
        return new OurDate($dateTime);
    }

}