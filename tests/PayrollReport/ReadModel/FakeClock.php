<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use DateTimeImmutable;
use Payroll\PayrollReport\DomainModel\Calculator\Clock;

class FakeClock implements Clock
{
    public function __construct(
        private readonly DateTimeImmutable $dateTime
    ) {
    }

    public function getCurrentTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }
}
