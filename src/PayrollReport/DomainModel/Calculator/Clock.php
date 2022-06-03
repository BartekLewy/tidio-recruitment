<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator;

use DateTimeImmutable;

interface Clock
{
    public function getCurrentTime(): DateTimeImmutable;
}
