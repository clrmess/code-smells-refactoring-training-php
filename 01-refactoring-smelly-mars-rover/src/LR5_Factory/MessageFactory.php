<?php

namespace App\LR5_Factory;

class MessageFactory
{
    public static function create(string $type): Message
    {
        return match (strtolower($type)) {
            'email' => new EmailMessage(),
            'sms' => new SMSMessage(),
            'push' => new PushNotification(),
            default => throw new InvalidArgumentException("Невідомий тип повідомлення: $type"),
        };
    }
}