<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Query\FilterQuery;
use Payroll\PayrollReport\ReadModel\Query\SortQuery;

class PayrollReportQuery
{
    private ?FilterQuery $filter = null;
    private ?SortQuery $sort = null;
    private ?\DateTimeImmutable $generationDate = null;

    public static function fromArray(array $data): self
    {
        $query = new self();

        if (array_key_exists('sort', $data) && $data['sort'] != []) {
            $sort = $data['sort'];
            $key = key($sort);
            $query->setSort(
                new SortQuery($key, $sort[$key])
            );
        }

        if (array_key_exists('filter', $data) && $data['filter'] != []) {
            $filter = $data['filter'];
            $key = key($filter);
            $query->setFilter(
                new FilterQuery($key, $filter[$key])
            );
        }

        return $query;
    }

    public function getFilter(): ?FilterQuery
    {
        return $this->filter;
    }

    public function setFilter(?FilterQuery $filter): void
    {
        $this->filter = $filter;
    }

    public function getSort(): ?SortQuery
    {
        return $this->sort;
    }

    public function setSort(?SortQuery $sort): void
    {
        $this->sort = $sort;
    }

    public function getGenerationDate(): \DateTimeImmutable
    {
        return $this->generationDate ?? new \DateTimeImmutable();
    }

    public function setGenerationDate(\DateTimeImmutable $generationDate): void
    {
        $this->generationDate = $generationDate;
    }
}
