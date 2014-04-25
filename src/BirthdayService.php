<?php

class BirthdayService
{
    private $employeeRepository;
    private $mailerService;

    public function __construct(EmployeeRepository $employeeRepository, MailerService $mailerService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->mailerService = $mailerService;
    }

    public function sendGreetings(XDate $xDate)
    {
        $employees = $this->employeeRepository->findAll();

        foreach ($employees as $employee) {
            if ($employee->isBirthday($xDate)) {
                $this->sendOneGreeting($employee);
            }
        }
    }

    private function sendOneGreeting($employee)
    {
        $message = $this->buildMessage($employee);
        $this->sendMessage($message);
    }

    private function buildMessage($employee)
    {
        $recipient = $employee->getEmail();
        $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject = 'Happy Birthday!';
        $message = $this->mailerService->buildMessage('sender@here.com', $subject, $body, $recipient);

        return $message;
    }

    protected function sendMessage($message)
    {
        $this->mailerService->sendMessage($message);
    }
}