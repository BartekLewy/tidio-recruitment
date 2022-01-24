<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\DomainModel\Calculator\ValueObject;

class BonusType implements \Stringable
{
    private const PERMANENT = 'permanent';

    private const PERCENTAGE = 'percentage';

    public function __construct(
        private readonly string $bonusType
    ) {
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
