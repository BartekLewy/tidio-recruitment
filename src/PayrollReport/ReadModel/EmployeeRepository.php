<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function getEmployees(): array;
}