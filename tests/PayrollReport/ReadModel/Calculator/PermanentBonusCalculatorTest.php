<?php

namespace Payroll\Tests\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Calculator\PermanentBonusCalculator;
use Payroll\PayrollReport\ReadModel\Employee;
use PHPUnit\Framework\TestCase;

class PermanentBonusCalculatorTest extends TestCase
{
    public function shouldSupportOnlyPermanentBonusType(): void
    {
        $calculator = new PermanentBonusCalculator();

        self::assertTrue($calculator->supports(BonusType::permanent()));
        self::assertFalse($calculator->supports(BonusType::percentage()));
    }

    /**
     * @test
     * @dataProvider getPayrollData
     */
    public function shouldCalculateBonusBasedOnPermanentBonusType(
        Employee $employee,
        \DateTimeImmutable $dateOfGeneratingReport,
        Money $expectedFullRemuneration
    ): void {
        $calculator = new PermanentBonusCalculator();
        $fullRemuneration = $calculator->calculate($employee, $dateOfGeneratingReport);

        self::assertTrue($expectedFullRemuneration->equals($fullRemuneration));
    }

    public function getPayrollData(): array
    {
        return [
            '11 months of employment' => [
                new Employee(
                    Money::USD(1000),
                    new \DateTimeImmutable('2021-10-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1000)
            ],
            '1 year of employment' => [
                new Employee(
                    Money::USD(1000),
                    new \DateTimeImmutable('2021-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1100)
            ],
            '5 years of employment' => [
                new Employee(
                    Money::USD(1000),
                    new \DateTimeImmutable('2017-09-01'),
                    BonusType::permanent()
                ),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1500)
            ],
            '10 years of employment' => [
                new Employee(
                    Money::USD(1000),
                    new \DateTimeImmutable('2012-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(2000)
            ],
            'More than 10 years of employment' => [
                new Employee(
                    Money::USD(1000),
                    new \DateTimeImmutable('2007-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(2000)
            ]
        ];
    }
}
