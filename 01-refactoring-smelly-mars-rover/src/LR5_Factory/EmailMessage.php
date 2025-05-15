<?php

namespace App\LR5_Factory;

use App\LR5_Factory\Message;

class EmailMessage implements Message
{

    public function send(): void
    {
        echo "Sending Email message";
    }
}