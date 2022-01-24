<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\Strategy;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;

interface BonusCalculator
{
    public function calculate(EmploymentDetailsDTO $employmentDetails, \DateTimeImmutable $dateOfGeneratingReport): Money;

    public function supports(BonusType $bonusType): bool;
}
