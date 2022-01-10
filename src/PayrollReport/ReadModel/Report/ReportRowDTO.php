<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Report;

use Money\Money;

class ReportRowDTO
{
    private string $firstName;
    private string $lastName;
    private string $department;
    private Money $basisOfRemuneration;
    private Money $additionalRemuneration;
    private string $bonusType;
    private Money $fullRemuneration;

    public function __construct(
        string $firstName,
        string $lastName,
        string $department,
        Money $basisOfRemuneration,
        Money $additionalRemuneration,
        string $bonusType,
        Money $fullRemuneration
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->basisOfRemuneration = $basisOfRemuneration;
        $this->additionalRemuneration = $additionalRemuneration;
        $this->bonusType = $bonusType;
        $this->fullRemuneration = $fullRemuneration;
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
