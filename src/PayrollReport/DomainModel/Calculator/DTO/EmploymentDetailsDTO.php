<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\DTO;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;

class EmploymentDetailsDTO
{
    public function __construct(
        private readonly Money $basisOfRemuneration,
        private readonly \DateTimeImmutable $dateOfEmployment,
        private readonly BonusType $bonusType
    ) {
    }

    public function getBasisOfRemuneration(): Money
    {
        return $this->basisOfRemuneration;
    }

    public function getDateOfEmployment(): \DateTimeImmutable
    {
        return $this->dateOfEmployment;
    }

    public function getBonusType(): BonusType
    {
        return $this->bonusType;
    }
}
