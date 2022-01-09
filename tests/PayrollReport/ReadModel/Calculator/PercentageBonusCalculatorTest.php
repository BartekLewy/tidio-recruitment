<?php

namespace Payroll\Tests\PayrollReport\ReadModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\ReadModel\BonusType;
use Payroll\PayrollReport\ReadModel\Calculator\PercentageBonusCalculator;
use Payroll\PayrollReport\ReadModel\Calculator\PermanentBonusCalculator;
use PHPUnit\Framework\TestCase;

class PercentageBonusCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSupportOnlyPercentageBonusType(): void
    {
        $calculator = new PercentageBonusCalculator();

        self::assertTrue($calculator->supports(BonusType::percentage()));
        self::assertFalse($calculator->supports(BonusType::permanent()));
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
        $calculator = new PercentageBonusCalculator();
        $fullRemuneration = $calculator->calculate($baseRemuneration, $dateOfEmployment, $dateOfGeneratingReport);

        self::assertTrue($expectedFullRemuneration->equals($fullRemuneration));
    }

    public function getPayrollData()
    {
        return [
            '11 months of employment' => [
                Money::USD(1100),
                new \DateTimeImmutable('2021-10-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1210)
            ],
            '1 year of employment' => [
                Money::USD(1500),
                new \DateTimeImmutable('2021-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(1650)
            ],
            '5 year of employment' => [
                Money::USD(2000),
                new \DateTimeImmutable('2017-09-01'),
                new \DateTimeImmutable('2022-09-01'),
                Money::USD(2200)
            ],
        ];
    }
}
