<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusCalculator;
use Payroll\PayrollReport\ReadModel\BonusType;

class PercentageBonusCalculator implements BonusCalculator
{
    public function calculate(
        Money $basisOfRemuneration,
        \DateTimeImmutable $dateOfEmployment,
        \DateTimeImmutable $dateOfGeneratingReport
    ): Money {
        return $basisOfRemuneration->add($basisOfRemuneration->multiply(10)->divide(100));
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::percentage()->equals($bonusType);
    }
}