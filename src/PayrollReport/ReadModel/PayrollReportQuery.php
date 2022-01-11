<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Exception\InvalidArgumentException;

class PayrollReportQuery
{
    private const ALLOWED_FIELDS_TO_SORT = [
        'firstName',
        'lastName',
        'department',
        'basisOfRemuneration',
        'bonusType',
        'remuneration'
    ];

    private const ALLOWED_FIELDS_TO_FILTER = [
        'department',
        'firstName',
        'lastName'
    ];

    private string $sortDirection;
    private string $orderBy;
    private ?\DateTimeImmutable $generationDate;
    private array $filterBy = [];

    public function __construct(
        string $sortDirection,
        string $orderBy,
        ?\DateTimeImmutable $generationDate = null,

    ) {
        if (!in_array($orderBy, static::ALLOWED_FIELDS_TO_SORT, true)) {
            throw InvalidArgumentException::invalidSortApplied($orderBy);
        }

        if (!in_array(strtoupper($sortDirection), ['ASC', 'DESC'], true)) {
            throw InvalidArgumentException::invalidSortOrder($sortDirection);
        }

        if ($filterBy && !in_array($filterBy, static::ALLOWED_FIELDS_TO_FILTER, true)) {
            throw InvalidArgumentException::invalidFilterApplied($filterBy);
        }

        $this->sortDirection = $sortDirection;
        $this->orderBy = $orderBy;
        $this->generationDate = $generationDate;
        $this->filterBy = $filterBy;
    }

    public static function createDefaultQuery(): static
    {
        return new static('lastName', 'ASC', new \DateTimeImmutable());
    }

    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function getGenerationDate(): ?\DateTimeImmutable
    {
        return $this->generationDate;
    }

    public function getFilterBy(): array
    {
        return $this->filterBy;
    }
}
