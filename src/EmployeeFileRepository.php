<?php

class EmployeeFileRepository implements EmployeeRepository
{
    private $fileHandler;
    private $fileName;

    private $employees;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    protected function getFileHandler()
    {
        if (is_null($this->fileHandler)) {
            $this->fileHandler = fopen($this->fileName, 'r');
            fgetcsv($this->fileHandler);
        }

        return $this->fileHandler;
    }

    public function findAll()
    {
        if (is_null($this->employees)) {
            $employees = [];
            while ($employeeData = fgetcsv($this->getFileHandler(), null, ',')) {
                $employees[] = $this->parseDataIntoEmployee($employeeData);
            }
            $this->employees = $employees;
        }

        return $this->employees;
    }

    public function findByBirthDayDate(XDate $xDate)
    {
        $employeesWithBirthday = [];

        foreach ($this->findAll() as $employee) {
            if ($employee->isBirthday($xDate)) {
                $employeesWithBirthday[] = $employee;
            }
        }

        return $employeesWithBirthday;
    }

    protected function parseDataIntoEmployee($employeeData)
    {
        $employeeData = array_map('trim', $employeeData);

        return new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
    }
}
