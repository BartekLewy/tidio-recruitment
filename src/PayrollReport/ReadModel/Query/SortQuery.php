<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Query;

use Payroll\PayrollReport\ReadModel\Exception\InvalidArgumentException;

final class SortQuery extends Query
{
    private const ALLOWED_FIELDS_TO_SORT = [
        'firstName',
        'lastName',
        'department',
        'basisOfRemuneration',
        'bonusType',
        'additionalRemuneration',
        'fullRemuneration',
    ];

    public function __construct(string $key, string $value)
    {
        if (!in_array($key, self::ALLOWED_FIELDS_TO_SORT)) {
            throw InvalidArgumentException::invalidSortApplied($key);
        }

        $value = strtoupper($value);
        if (!in_array($value, ['ASC', 'DESC'])) {
            throw InvalidArgumentException::invalidSortOrder();
        }

        parent::__construct($key, $value);
    }
}