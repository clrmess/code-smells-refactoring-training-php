<?php

declare(strict_types=1);


namespace App\application;


use App\core\Employee;
use App\core\EmployeeRepository;
use App\core\GreetingMessage;
use App\core\OurDate;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings(
        OurDate $date,
        string  $smtpHost,
        int     $smtpPort,
        string  $sender
    ): void
    {

        $this->sendMessages($this->greetingMessagesFor($this->employeesHavingBirthday($date)),
            $smtpHost, $smtpPort, $sender);
    }

    private function greetingMessagesFor(array $employees): array
    {
        return GreetingMessage::generateForSome($employees);
    }

    private function employeesHavingBirthday($today): array
    {
        return array_values(array_filter(
            $this->employeeRepository->getAll(),
            function (Employee $employee) use ($today) {
                return $employee->isBirthday($today);
            }
        ));
    }

    private function sendMessages(array $messages, string $smtpHost, int $smtpPort, string $sender): void
    {
        /** @var GreetingMessage $message */
        foreach ($messages as $message) {
            $recipient = $message->getTo();
            $body = $message->getText();
            $subject = $message->getSubject();
            $this->sendMessage($smtpHost, $smtpPort, $sender, $subject, $body, $recipient);
        }
    }

    private function sendMessage(
        string $smtpHost,
        int    $smtpPort,
        string $sender,
        string $subject,
        string $body,
        string $recipient
    ): void
    {
        $mailer = new Swift_Mailer(
            new Swift_SmtpTransport($smtpHost, $smtpPort)
        );

        $msg = new Swift_Message($subject);
        $msg->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body);

        $this->send($msg, $mailer);
    }

    // made protected for testing :-(
    protected function send(Swift_Message $msg, Swift_Mailer $mailer): void
    {
        $mailer->send($msg);
    }

}