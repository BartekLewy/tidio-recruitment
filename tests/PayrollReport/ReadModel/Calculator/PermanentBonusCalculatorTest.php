<?php

namespace Payroll\Tests\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Calculator\PermanentBonusCalculator;
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
        Money $baseRemuneration,
        \DateTimeImmutable $dateOfEmployment,
        \DateTimeImmutable $dateOfGeneratingReport,
        Money $expectedFullRemuneration
    ): void {
        $calculator = new PermanentBonusCalculator();
        $fullRemuneration = $calculator->calculate($baseRemuneration, $dateOfEmployment, $dateOfGeneratingReport);

        self::assertTrue($expectedFullRemuneration->equals($fullRemuneration));
    }

    public function getPayrollData(): array
    {
        return [
            '11 months of employment' => [
                Money::USD(1000),
                new \DateTimeImmutable('2021-10-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1000)
            ],
            '1 year of employment' => [
                Money::USD(1000),
                new \DateTimeImmutable('2021-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1100)
            ],
            '5 year of employment' => [
                Money::USD(1000),
                new \DateTimeImmutable('2017-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1500)
            ],
            '10 year of employment' => [
                Money::USD(1000),
                new \DateTimeImmutable('2012-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(2000)
            ],
            '15 year of employment' => [
                Money::USD(1000),
                new \DateTimeImmutable('2007-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(2000)
            ]
        ];
    }
}
