<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Report;

use Payroll\PayrollReport\DomainModel\Calculator\DTO\RemunerationDTO;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;

class PayrollReportMapper
{
    public static function map(EmployeeDTO $employee, RemunerationDTO $remuneration): ReportRowDTO
    {
        return new ReportRowDTO(
            $employee->getFirstName(),
            $employee->getLastName(),
            $employee->getDepartment(),
            $remuneration->getBaseRemuneration(),
            $remuneration->getAdditionalRemuneration(),
            $employee->getBonusType(),
            $remuneration->getFullRemuneration()
        );
    }
}