<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Employee;

use Payroll\PayrollReport\ReadModel\Query\FilterQuery;
use Payroll\PayrollReport\ReadModel\Query\SortQuery;

interface EmployeeRepository
{
    /**
     * @return EmployeeDTO[]
     */
    public function getEmployees(?FilterQuery $filterQuery, ?SortQuery $sortQuery): array;
}
