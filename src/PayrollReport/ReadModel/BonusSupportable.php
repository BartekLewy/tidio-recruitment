<?php

namespace Payroll\PayrollReport\ReadModel;

interface BonusSupportable
{
    public function supports(BonusType $bonusType): bool;
}