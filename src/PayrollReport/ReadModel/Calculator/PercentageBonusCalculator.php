<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusCalculator;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Employee;

class PercentageBonusCalculator implements BonusCalculator
{
    public function calculate(Employee $employee, \DateTimeImmutable $dateOfGeneratingReport): Money
    {
        $basisOfRemuneration = $employee->getBasisOfRemuneration();

        return $basisOfRemuneration->add(
            $basisOfRemuneration->multiply(10)->divide(100)
        );
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::percentage()->equals($bonusType);
    }
}