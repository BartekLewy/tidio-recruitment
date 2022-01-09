<?php

namespace Payroll\PayrollReport\ReadModel;

use Money\Money;

interface BonusCalculable
{
    public function calculate(Employee $employee, \DateTimeImmutable $dateOfGeneratingReport): Money;
}