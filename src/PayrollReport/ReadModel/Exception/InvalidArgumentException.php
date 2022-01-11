<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel\Exception;

final class InvalidArgumentException extends \DomainException
{
    private const INVALID_SORT_APPLIED_CODE = 1000;
    private const INVALID_SORT_ORDER_CODE = 1001;
    private const INVALID_FILTER_APPLIED_CODE = 1002;

    public static function invalidSortApplied(string $field): self
    {
        return new self(
            sprintf('Field %s is not supported for sorting', $field),
            self::INVALID_SORT_APPLIED_CODE
        );
    }

    public static function invalidSortOrder(string $order): self
    {
        return new self(
            sprintf('An order %s is not supported, use ASC or DESC instead', $order),
            self::INVALID_SORT_ORDER_CODE
        );
    }

    public static function invalidFilterApplied(string $field): self
    {
        return new self(
            sprintf('Field %s is not valid filter', $field),
            self::INVALID_FILTER_APPLIED_CODE
        );
    }
}