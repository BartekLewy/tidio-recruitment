<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Report;

use Money\Money;

class ReportRowDTO
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $department,
        private readonly Money $basisOfRemuneration,
        private readonly Money $additionalRemuneration,
        private readonly string $bonusType,
        private readonly Money $fullRemuneration
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function getBasisOfRemuneration(): Money
    {
        return $this->basisOfRemuneration;
    }

    public function getAdditionalRemuneration(): Money
    {
        return $this->additionalRemuneration;
    }

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getFullRemuneration(): Money
    {
        return $this->fullRemuneration;
    }
}
