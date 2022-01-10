<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\Infrastructure\Employee;

use Doctrine\DBAL\Connection;
use Money\Money;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeRepository;

class EmployeeDbalRepository implements EmployeeRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getEmployees(): array
    {
        $result = $this
            ->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('employees', 'e')
            ->join('e', 'departments', 'd', 'e.department_id = d.id')
            ->fetchAllAssociative();

        return array_map(
            static fn(array $rawData) => new EmployeeDTO(
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
