<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Query;

abstract class Query
{
    public function __construct(
        private readonly string $key,
        private readonly string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
