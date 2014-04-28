<?php

class NotificationService
{
    private $mailerService;

    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function sendGreetingTo($employee)
    {
        $subject = 'Happy Birthday!';
        $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $recipient = $employee->getEmail();

        $this->mailerService->sendMessage('sender@here.com', $subject, $body, $recipient);
    }
}