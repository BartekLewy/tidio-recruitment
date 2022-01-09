<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

class PayrollReportGenerator
{
    private EmployeeRepository $employeeRepository;
    /** @var BonusCalculator[] */
    private array $calculators;

    public function __construct(EmployeeRepository $employeeRepository, BonusCalculator ...$calculators)
    {
        $this->employeeRepository = $employeeRepository;
        $this->calculators = $calculators;
    }

    public function generate(\DateTimeImmutable $dateOfGenerationReport): array
    {
        $employees = $this->employeeRepository->getEmployees();

        $rows = [];

        foreach ($employees as $employee) {
            $row = [
                'dateOfEmployment' => $employee->getDateOfEmployment()->format(\DateTimeInterface::ATOM),
                'bonusType' => (string)$employee->getBonusType()
            ];
            foreach ($this->calculators as $calculator) {
                if ($calculator->supports($employee->getBonusType())) {
                    $row['fullRemuneration'] = $calculator->calculate($employee, $dateOfGenerationReport);
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }
}