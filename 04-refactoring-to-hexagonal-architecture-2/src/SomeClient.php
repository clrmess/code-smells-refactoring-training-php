<?php

namespace App;

use App\application\BirthdayService;
use App\core\OurDate;
use App\infrastructure\repositories\FileEmployeesRepository;
use DateTime;

class SomeClient
{
    private const SMTP_HOST = '127.0.0.1';
    private const SMTP_PORT = 25;
    private const FROM = 'sender@here.com';
    private const EMPLOYEES_FILE_PATH = "/resources/employee_data.txt";

    public function someMethod(): void
    {
        $birthdayService = new BirthdayService(
            new FileEmployeesRepository(dirname(__FILE__) . self::EMPLOYEES_FILE_PATH));
        $birthdayService->sendGreetings(
            new OurDate(new DateTime()),
            self::SMTP_HOST,
            self::SMTP_PORT,
            self::FROM
        );
    }
}