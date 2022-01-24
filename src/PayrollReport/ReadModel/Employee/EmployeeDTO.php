<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Employee;

use Money\Money;

class EmployeeDTO
{
    public function __construct(private readonly string $firstName, private readonly string $lastName, private readonly string $department, private readonly Money $basisOfRemuneration, private readonly string $bonusType, private readonly \DateTimeImmutable $dateOfEmployment)
    {
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
