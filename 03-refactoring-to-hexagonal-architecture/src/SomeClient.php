<?php

namespace App;

class SomeClient
{
    private const SMTP_HOST = '127.0.0.1';
    private const SMTP_PORT = 25;
    private const EMPLOYEES_FILE_PATH = "/resources/employee_data.txt";

    private function someMethod(): void{
        $birthdayService = new BirthdayService();
        $birthdayService->sendGreetings(
            dirname(__FILE__) . self::EMPLOYEES_FILE_PATH,
            new OurDate('2008/10/08'),
            self::SMTP_HOST,
            self::SMTP_PORT
        );
    }
}