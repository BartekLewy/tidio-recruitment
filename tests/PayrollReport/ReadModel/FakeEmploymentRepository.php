<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeRepository;
use Payroll\PayrollReport\ReadModel\Query\FilterQuery;
use Payroll\PayrollReport\ReadModel\Query\SortQuery;

class FakeEmploymentRepository implements EmployeeRepository
{
    /** @var EmployeeDTO[] */
    private array $employees;

    public function __construct(EmployeeDTO ...$employees)
    {
        $this->employees = $employees;
    }

    public function getEmployees(?FilterQuery $filterQuery, ?SortQuery $sortQuery): array
    {
        return $this->employees;
    }
}