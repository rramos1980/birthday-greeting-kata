<?php

class EmployeeRepository
{
    private $fileHandler;
    private $fileName;

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
        $employees = [];
        while ($employeeData = fgetcsv($this->getFileHandler(), null, ',')) {
            $employees[] = $this->parseDataIntoEmployee($employeeData);
        }

        return $employees;
    }

    protected function parseDataIntoEmployee($employeeData)
    {
        $employeeData = array_map('trim', $employeeData);

        return new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
    }
}
