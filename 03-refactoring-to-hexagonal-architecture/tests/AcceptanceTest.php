<?php

declare(strict_types=1);

use App\BirthdayService;
use App\OurDate;
use PHPUnit\Framework\TestCase;

class AcceptanceTest extends TestCase
{
    private const SMTP_HOST = '127.0.0.1';
    private const SMTP_PORT = 25;
    private BirthdayService $service;

    /** @before */
    protected function setUp(): void
    {
        $this->service = new class() extends BirthdayService {
            private array $messagesSent = [];

            protected function send(Swift_Message $msg, Swift_Mailer $mailer): void
            {
                $this->messagesSent[] = $msg;
            }

            public function countSentMessages(): int
            {
                return count($this->messagesSent);
            }

            public function getNthMessage(int $n): Swift_Message
            {
                return $this->messagesSent[$n];
            }
        };
    }

    /** @test */
    public function willSendGreetings_whenItsSomebodysBirthday(): void
    {
        $this->service->sendGreetings(
            dirname(__FILE__) . '/resources/employee_data.txt',
            new OurDate('2008/10/08'),
            self::SMTP_HOST,
            self::SMTP_PORT
        );

        $this->assertEquals(1, $this->service->countSentMessages(), 'message not sent?');
        /** @var Swift_Message $message */
        $message =  $this->service->getNthMessage(0);
        $this->assertEquals('Happy Birthday, dear John!', $message->getBody());
        $this->assertEquals('Happy Birthday!', $message->getSubject());
        $this->assertEquals('john.doe@foobar.com', key($message->getTo()));
    }

    /** @test */
    public function willNotSendEmailsWhenNobodysBirthday(): void
    {
        $this->service->sendGreetings(
            dirname(__FILE__) . '/resources/employee_data.txt',
            new OurDate('2008/01/01'),
            self::SMTP_HOST,
            self::SMTP_PORT
        );

        $this->assertEquals(0, $this->service->countSentMessages(), 'what? messages?');
    }
}
