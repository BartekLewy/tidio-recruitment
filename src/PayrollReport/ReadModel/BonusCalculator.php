<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Money\Money;

interface BonusCalculator
{
    public function calculate(
        Money $basisOfRemuneration,
        \DateTimeImmutable $dateOfEmployment,
        \DateTimeImmutable $dateOfGeneratingReport
    ): Money;

    public function supports(BonusType $bonusType): bool;
}