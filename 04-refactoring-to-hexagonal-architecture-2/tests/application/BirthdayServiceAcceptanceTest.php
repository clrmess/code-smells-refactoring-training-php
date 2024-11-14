<?php

declare(strict_types=1);

namespace application;

use App\application\BirthdayService;
use App\core\EmployeeRepository;
use App\infrastructure\repositories\FileEmployeesRepository;
use helpers\OurDateFactory;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Swift_Message;

class BirthdayServiceAcceptanceTest extends TestCase
{
    private const SMTP_HOST = '127.0.0.1';
    private const SMTP_PORT = 25;
    private const FROM = 'sender@here.com';
    private BirthdayService $service;
    private const EMPLOYEES_FILE_PATH = "/../resources/employee_data.txt";

    /** @before */
    protected function setUp(): void
    {
        $employeesFilePath = dirname(__FILE__) . self::EMPLOYEES_FILE_PATH;
        $this->service = new class([], new FileEmployeesRepository($employeesFilePath)) extends BirthdayService {

            public $messagesSent;

            public function __construct($messagesSent, EmployeeRepository $employeeRepository)
            {
                parent::__construct($employeeRepository);
                $this->messagesSent = $messagesSent;
            }

            protected function send(Swift_Message $msg, Swift_Mailer $mailer): void
            {
                $this->messagesSent[] = $msg;
            }
        };
    }

    /** @test */
    public function baseScenario(): void
    {
        $today = OurDateFactory::ourDateFromString("2008/10/08");

        $this->service->sendGreetings($today, self::SMTP_HOST, self::SMTP_PORT, self::FROM);

        $this->assertEquals(1, count($this->service->messagesSent), "message not sent?");
        /* @var Swift_Message $message */
        $message = $this->service->messagesSent[0];
        $this->assertEquals("Happy Birthday, dear John!", $message->getBody());
        $this->assertEquals("Happy Birthday!", $message->getSubject());
        $this->assertEquals(1, count($message->getTo()));
        $this->assertEquals("john.doe@foobar.com", key($message->getTo()));
    }

    /** @test */
    public function willNotSendEmailsWhenNobodysBirthday(): void
    {
        $today = OurDateFactory::ourDateFromString('2008/01/01');

        $this->service->sendGreetings(
            $today,
            self::SMTP_HOST,
            self::SMTP_PORT,
            self::FROM
        );

        $this->assertEquals(0, count($this->service->messagesSent), 'what? messages?');
    }
}
