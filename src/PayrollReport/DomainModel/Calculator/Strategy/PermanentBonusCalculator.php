<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\Strategy;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;

class PermanentBonusCalculator implements BonusCalculator
{
    private const BASIS_OF_ADDITIONAL = 10000;

    private const MAX_YEARLY_MULTIPLIER = 10;

    public function calculate(
        EmploymentDetailsDTO $employmentDetails,
        \DateTimeImmutable $dateOfGeneratingReport
    ): Money {
        $years = $dateOfGeneratingReport->diff($employmentDetails->getDateOfEmployment(), true)->y;
        $limitOfBonusHasBeenReached = $years >= self::MAX_YEARLY_MULTIPLIER;

        if ($limitOfBonusHasBeenReached) {
            return Money::USD(self::BASIS_OF_ADDITIONAL)->multiply(self::MAX_YEARLY_MULTIPLIER);
        }
        return Money::USD(self::BASIS_OF_ADDITIONAL)->multiply($years);
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::permanent()->equals($bonusType);
    }
}
