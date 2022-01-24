<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\Exception;

class CalculatorNotFoundException extends \Exception
{
    public static function forBonusType(string $bonusType): static
    {
        return new self(sprintf('No calculator found for %s bonus type', $bonusType));
    }
}
