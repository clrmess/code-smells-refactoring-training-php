<?php

namespace App\LR5_Factory;

use App\LR5_Factory\Message;

class SMSMessage implements Message
{

    public function send(): void
    {
        echo "Sending SMS message";
    }
}