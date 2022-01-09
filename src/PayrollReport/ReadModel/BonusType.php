<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

class BonusType
{
    private const PERMANENT = 'permanent';
    private const PERCENTAGE = 'percentage';

    private string $bonusType;

    private function __construct(string $bonusType)
    {
        $this->bonusType = $bonusType;
    }

    public static function permanent(): self
    {
        return new self(self::PERMANENT);
    }

    public static function percentage(): self
    {
        return new self(self::PERCENTAGE);
    }

    public function equals(BonusType $bonusType): bool
    {
        return $this->bonusType === $bonusType->bonusType;
    }

    public function __toString(): string
    {
        return $this->bonusType;
    }
}