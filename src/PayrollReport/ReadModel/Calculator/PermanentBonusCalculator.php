<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusCalculator;
use Payroll\PayrollReport\ReadModel\BonusType;

class PermanentBonusCalculator implements BonusCalculator
{
    public function calculate(
        Money $basisOfRemuneration,
        \DateTimeImmutable $dateOfEmployment,
        \DateTimeImmutable $dateOfGeneratingReport
    ): Money {
        $years = $dateOfGeneratingReport->diff($dateOfEmployment, true)->y;
        $limitOfBonusHasBeenReached = $years >= 10;

        if ($limitOfBonusHasBeenReached) {
            return $basisOfRemuneration->add(Money::USD(1000));
        }
        return $basisOfRemuneration->add(Money::USD(100)->multiply($years));
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::permanent()->equals($bonusType);
    }
}
