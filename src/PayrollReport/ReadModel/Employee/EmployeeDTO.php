<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Employee;

use Money\Money;

class EmployeeDTO
{
    private string $firstName;
    private string $lastName;
    private string $department;
    private Money $basisOfRemuneration;
    private string $bonusType;
    private \DateTimeImmutable $dateOfEmployment;

    public function __construct(
        string $firstName,
        string $lastName,
        string $department,
        Money $basisOfRemuneration,
        string $bonusType,
        \DateTimeImmutable $dateOfEmployment
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->department = $department;
        $this->basisOfRemuneration = $basisOfRemuneration;
        $this->bonusType = $bonusType;
        $this->dateOfEmployment = $dateOfEmployment;
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

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getDateOfEmployment(): \DateTimeImmutable
    {
        return $this->dateOfEmployment;
    }
}
