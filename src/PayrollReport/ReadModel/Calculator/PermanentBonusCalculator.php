<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusCalculator;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Employee;

class PermanentBonusCalculator implements BonusCalculator
{
    public function calculate(Employee $employee, \DateTimeImmutable $dateOfGeneratingReport): Money
    {
        $years = $dateOfGeneratingReport->diff($employee->getDateOfEmployment(), true)->y;
        $limitOfBonusHasBeenReached = $years >= 10;

        if ($limitOfBonusHasBeenReached) {
            return $employee->getBasisOfRemuneration()->add(Money::USD(1000));
        }
        return $employee->getBasisOfRemuneration()->add(Money::USD(100)->multiply($years));
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::permanent()->equals($bonusType);
    }
}
