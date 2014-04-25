<?php

interface EmployeeRepository
{
    public function findAll();

    public function findByBirthDayDate(XDate $xDate);
}