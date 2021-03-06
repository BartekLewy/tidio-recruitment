<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Payroll\PayrollReport\DomainModel\Calculator\Clock;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\Exception\CalculatorNotFoundException;
use Payroll\PayrollReport\DomainModel\Calculator\RemunerationCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeRepository;
use Payroll\PayrollReport\ReadModel\Report\PayrollReportMapper;
use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;

class PayrollReportGenerator implements ReportGenerator
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly RemunerationCalculator $remunerationCalculator,
        private readonly Clock $clock
    ) {
    }

    /**
     * @return ReportRowDTO[]
     * @throws CalculatorNotFoundException
     */
    public function generate(PayrollReportQuery $query): array
    {
        $result = [];

        foreach ($this->employeeRepository->getEmployees($query->getFilter(), $query->getSort()) as $employee) {
            $result[] = PayrollReportMapper::map(
                $employee,
                $this->remunerationCalculator->calculate(
                    new EmploymentDetailsDTO(
                        $employee->getBasisOfRemuneration(),
                        $employee->getDateOfEmployment(),
                        new BonusType($employee->getBonusType()),
                        $employee->getBonus()
                    ),
                    $this->clock->getCurrentTime()
                )
            );
        }

        return $result;
    }
}
