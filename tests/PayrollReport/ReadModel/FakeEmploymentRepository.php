<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeRepository;

class FakeEmploymentRepository implements EmployeeRepository
{
    /** @var EmployeeDTO[] */
    private array $employees;

    public function __construct(EmployeeDTO ...$employees)
    {
        $this->employees = $employees;
    }

    public function getEmployees(): array
    {
        return $this->employees;
    }
}