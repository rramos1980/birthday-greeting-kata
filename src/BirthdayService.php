<?php

class BirthdayService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

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
        $recipient = $employee->getEmail();
        $body = sprintf('Happy Birthday, dear %s!', $employee->getFirstName());
        $subject = 'Happy Birthday!';
        $this->sendMessage($subject, $body, $recipient);
    }

    protected function sendMessage($subject, $body, $recipient)
    {
        $this->mailerService->sendMessage('sender@here.com', $subject, $body, $recipient);
    }
}