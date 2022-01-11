<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Query;

use Payroll\PayrollReport\ReadModel\Exception\InvalidArgumentException;

final class FilterQuery extends Query
{
    private const ALLOWED_FIELDS_TO_FILTER = [
        'firstName',
        'lastName',
        'department',
    ];

    public function __construct(string $key, string $value)
    {
        if (!in_array($key, self::ALLOWED_FIELDS_TO_FILTER)) {
            throw InvalidArgumentException::invalidFilterApplied($key);
        }
        parent::__construct($key, $value);
    }
}