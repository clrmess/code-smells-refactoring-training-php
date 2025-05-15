<?php

namespace App\LR5_Factory;

use App\LR5_Factory\Message;

class PushNotification implements Message
{

    public function send(): void
    {
        echo "Sending Push-notification";
    }
}