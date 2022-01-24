<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\DTO;

use Money\Money;

class RemunerationDTO
{
    public function __construct(
        private readonly Money $baseRemuneration,
        private readonly Money $additionalRemuneration
    ) {
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
