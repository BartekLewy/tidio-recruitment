<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator;

use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\RemunerationDTO;
use Payroll\PayrollReport\DomainModel\Calculator\Exception\CalculatorNotFoundException;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\BonusCalculator;

class RemunerationCalculator
{
    /**
     * @var BonusCalculator[]
     */
    private readonly array $calculators;

    public function __construct(BonusCalculator ...$calculators)
    {
        $this->calculators = $calculators;
    }

    public function calculate(
        EmploymentDetailsDTO $employmentDetails,
        \DateTimeImmutable $calculationDate
    ): RemunerationDTO {
        foreach ($this->calculators as $calculator) {
            if ($calculator->supports($employmentDetails->getBonusType())) {
                return new RemunerationDTO(
                    $employmentDetails->getBasisOfRemuneration(),
                    $calculator->calculate($employmentDetails, $calculationDate)
                );
            }
        }

        throw CalculatorNotFoundException::forBonusType((string) $employmentDetails->getBonusType());
    }
}
