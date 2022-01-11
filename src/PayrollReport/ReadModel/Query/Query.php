<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Query;

abstract class Query
{
    private string $key;
    private string $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
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