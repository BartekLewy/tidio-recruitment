<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\Infrastructure;

use DateTimeImmutable;
use Payroll\PayrollReport\DomainModel\Calculator\Clock;

class SystemClock implements Clock
{
    public function getCurrentTime(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
