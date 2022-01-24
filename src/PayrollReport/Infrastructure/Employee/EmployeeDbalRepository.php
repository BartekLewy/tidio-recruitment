<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\Infrastructure\Employee;

use Doctrine\DBAL\Connection;
use Money\Money;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeRepository;
use Payroll\PayrollReport\ReadModel\Query\FilterQuery;
use Payroll\PayrollReport\ReadModel\Query\SortQuery;

final class EmployeeDbalRepository implements EmployeeRepository
{
    private const FILTER_FIELDS_TO_COLUMN_MAPPING = [
        'firstName' => 'e.firstname',
        'lastName' => 'e.lastname',
        'department' => 'd.name',
    ];

    private const SORT_FIELDS_TO_COLUMN_MAPPING = [
        'firstName' => 'e.firstname',
        'lastName' => 'e.lastname',
        'department' => 'd.name',
        'basisOfRemuneration' => 'e.basis_of_remuneration',
        'bonusType' => 'd.bonus_type',
    ];

    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function getEmployees(?FilterQuery $filterQuery, ?SortQuery $sortQuery): array
    {
        $query = $this
            ->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('employees', 'e')
            ->join('e', 'departments', 'd', 'e.department_id = d.id');

        if ($filterQuery) {
            $query->where(sprintf('%s = :value', self::FILTER_FIELDS_TO_COLUMN_MAPPING[$filterQuery->getKey()]));
            $query->setParameter('value', $filterQuery->getValue());
        }

        if ($sortQuery) {
            $orderBy = self::SORT_FIELDS_TO_COLUMN_MAPPING[$sortQuery->getKey()] ?? 'd.name';
            $query->orderBy($orderBy, $sortQuery->getValue());
        }

        $result = $query->fetchAllAssociative();

        return array_map(
            static fn (array $rawData): \Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO => new EmployeeDTO(
                $rawData['firstname'],
                $rawData['lastname'],
                $rawData['name'],
                Money::USD($rawData['basis_of_remuneration']),
                $rawData['bonus_type'],
                new \DateTimeImmutable($rawData['employed_on']),
            ),
            $result
        );
    }
}
