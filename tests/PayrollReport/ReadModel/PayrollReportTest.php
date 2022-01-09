<?php

namespace Payroll\Tests\PayrollReport\ReadModel;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Calculator\PercentageBonusCalculator;
use Payroll\PayrollReport\ReadModel\Calculator\PermanentBonusCalculator;
use Payroll\PayrollReport\ReadModel\Employee;
use Payroll\PayrollReport\ReadModel\EmployeeRepository;
use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PayrollReportTest extends TestCase
{
    private MockObject|EmployeeRepository $employeeRepositoryMock;
    private PayrollReportGenerator $systemUnderTest;

    public function setUp(): void
    {
        $this->employeeRepositoryMock = $this->createMock(EmployeeRepository::class);

        $this->systemUnderTest = new PayrollReportGenerator(
            $this->employeeRepositoryMock,
            ... [new PercentageBonusCalculator(), new PermanentBonusCalculator()]
        );
    }

    /**
     * @test
     */
    public function shouldGenerateEmptyReport(): void
    {
        $this->employeeRepositoryMock
            ->expects(self::once())
            ->method('getEmployees')
            ->willReturn([]);

        self::assertSame([], $this->systemUnderTest->generate(new \DateTimeImmutable()));
    }

    /**
     * @test
     * @dataProvider getPayrollData
     */
    public function shouldGenerateReportWithTwoEmployees(array $employees, array $expectedReport): void
    {
        $this->employeeRepositoryMock
            ->expects(self::once())
            ->method('getEmployees')
            ->willReturn($employees);

        $report = $this->systemUnderTest->generate(new \DateTimeImmutable('2022-01-09'));

        self::assertEquals($expectedReport, $report);
    }

    public function getPayrollData(): array
    {
        return [
            [
                [
                    new Employee(Money::USD(1000), new \DateTimeImmutable('2021-01-09'), BonusType::permanent()),
                    new Employee(Money::USD(1100), new \DateTimeImmutable('2021-01-09'), BonusType::percentage())
                ],
                [
                    [
                        'dateOfEmployment' => (new \DateTimeImmutable('2021-01-09'))->format(\DateTimeInterface::ATOM),
                        'bonusType' => 'permanent',
                        'fullRemuneration' => Money::USD(1100)
                    ],
                    [
                        'dateOfEmployment' => (new \DateTimeImmutable('2021-01-09'))->format(\DateTimeInterface::ATOM),
                        'bonusType' => 'percentage',
                        'fullRemuneration' => Money::USD(1210)
                    ]
                ]
            ]
        ];
    }
}
