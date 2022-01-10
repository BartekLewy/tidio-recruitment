<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Employee;

interface EmployeeRepository
{
    /**
     * @return EmployeeDTO[]
     */
    public function getEmployees(): array;
}