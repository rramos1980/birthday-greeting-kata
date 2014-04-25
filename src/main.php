<?php

$service = new BirthdayService(
    new EmployeeFileRepository('employee_data.txt'),
    new SwiftMailerService('localhost', 25)
);
$service->sendGreetings(new XDate('2008/10/08'));