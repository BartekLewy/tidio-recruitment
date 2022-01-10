<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\DomainModel\Calculator;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\EmploymentDetailsDTO;
use Payroll\PayrollReport\DomainModel\Calculator\DTO\RemunerationDTO;
use Payroll\PayrollReport\DomainModel\Calculator\Exception\CalculatorNotFoundException;
use Payroll\PayrollReport\DomainModel\Calculator\RemunerationCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PercentageBonusCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PermanentBonusCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\ValueObject\BonusType;
use PHPUnit\Framework\TestCase;

class RemunerationCalculatorTest extends TestCase
{
    public function shouldThrowCalculatorNotFoundException(): void
    {
        self::expectException(CalculatorNotFoundException::class);

        $calculator = new RemunerationCalculator(...[]);
        $calculator->calculate(
            new EmploymentDetailsDTO(
                Money::USD(1500),
                new \DateTimeImmutable('2021-09-01'),
                BonusType::permanent()
            ),
            new \DateTimeImmutable()
        );
    }

    /**
     * @test
     * @dataProvider getEmploymentDetailsDataProvider
     */
    public function shouldCalculateCorrectRemuneration(
        EmploymentDetailsDTO $employmentDetails,
        \DateTimeImmutable $generationDate,
        RemunerationDTO $expectedRemuneration
    ): void {
        $calculator = new RemunerationCalculator(
            new PermanentBonusCalculator(),
            new PercentageBonusCalculator()
        );

        $actualRemuneration = $calculator->calculate($employmentDetails, $generationDate);

        self::assertEquals($expectedRemuneration, $actualRemuneration);
    }

    public function getEmploymentDetailsDataProvider()
    {
        return [
            '11 months of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(100000),
                    new \DateTimeImmutable('2021-10-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(100000), Money::USD(0)),
            ],
            '11 months of employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(100000),
                    new \DateTimeImmutable('2021-10-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(100000), Money::USD(10000)),
            ],
            '1 year of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2021-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(10000)),
            ],
            '1 year of employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2021-09-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(15000)),
            ],
            '1,5 year of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2021-03-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(10000)),
            ],
            '1,5 year of employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2021-03-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(15000)),
            ],
            '5 years of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2017-05-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(50000)),
            ],
            '5 years of employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2017-09-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(15000)),
            ],
            '10 years of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2012-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(100000)),
            ],
            '10 years of employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2012-09-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(15000)),
            ],
            'More than 10 years of employment - permanent bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2007-09-01'),
                    BonusType::permanent(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(100000)),
            ],
            'More than 10 years employment - percentage bonus' => [
                new EmploymentDetailsDTO(
                    Money::USD(150000),
                    new \DateTimeImmutable('2007-09-01'),
                    BonusType::percentage(),
                ),
                new \DateTimeImmutable('2022-09-01'),
                new RemunerationDTO(Money::USD(150000), Money::USD(15000)),
            ],
        ];
    }
}
