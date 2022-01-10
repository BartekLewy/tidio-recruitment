<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\DTO;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;

class EmploymentDetailsDTO
{
    private Money $basisOfRemuneration;
    private \DateTimeImmutable $dateOfEmployment;
    private BonusType $bonusType;

    public function __construct(Money $basisOfRemuneration, \DateTimeImmutable $dateOfEmployment, BonusType $bonusType)
    {
        $this->basisOfRemuneration = $basisOfRemuneration;
        $this->dateOfEmployment = $dateOfEmployment;
        $this->bonusType = $bonusType;
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