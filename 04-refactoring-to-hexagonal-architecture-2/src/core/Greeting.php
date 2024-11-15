<?php

namespace App\core;

class Greeting
{
    private string $header;
    private string $content;

    public function __construct(string $header, string $content)
    {
        $this->header = $header;
        $this->content = $content;
    }

    public static function forBirthdayOf(Employee $employee): Greeting
    {
        $header = "Happy Birthday!";
        $content = "Happy Birthday, dear {$employee->getFirstName()}!";
        return new Greeting($header, $content);
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getContent(): string
    {
        return $this->content;
    }

}