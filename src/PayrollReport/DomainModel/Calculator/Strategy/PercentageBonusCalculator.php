<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\Strategy;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;

class PercentageBonusCalculator implements BonusCalculator
{
    public function calculate(EmploymentDetailsDTO $employmentDetails, \DateTimeImmutable $dateOfGeneratingReport): Money
    {
        return $employmentDetails->getBasisOfRemuneration()->multiply(10)->divide(100);
    }

    public function supports(BonusType $bonusType): bool
    {
        return BonusType::percentage()->equals($bonusType);
    }
}