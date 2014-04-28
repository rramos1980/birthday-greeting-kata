<?php

class BirthdayService
{
    private $employeeRepository;
    private $notificationService;

    public function __construct(EmployeeRepository $employeeRepository, NotificationService $notificationService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->notificationService = $notificationService;
    }

    public function sendGreetings(XDate $xDate)
    {
        $employees = $this->employeeRepository->findByBirthDayDate($xDate);

        foreach ($employees as $employee) {
            $this->notificationService->sendGreetingTo($employee);
        }
    }
}