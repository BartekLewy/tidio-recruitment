<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\DTO;

use Money\Money;

class RemunerationDTO
{
    private Money $baseRemuneration;
    private Money $additionalRemuneration;

    public function __construct(Money $baseRemuneration, Money $additionalRemuneration)
    {
        $this->baseRemuneration = $baseRemuneration;
        $this->additionalRemuneration = $additionalRemuneration;
    }

    public function getBaseRemuneration(): Money
    {
        return $this->baseRemuneration;
    }

    public function getAdditionalRemuneration(): Money
    {
        return $this->additionalRemuneration;
    }

    public function getFullRemuneration(): Money
    {
        return $this->baseRemuneration->add($this->additionalRemuneration);
    }
}