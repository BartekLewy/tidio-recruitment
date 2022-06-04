<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use DateTimeImmutable;
use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\RemunerationCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PercentageBonusCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PermanentBonusCalculator;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use Payroll\PayrollReport\ReadModel\PayrollReportQuery;
use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;
use PHPUnit\Framework\TestCase;

class PayrollReportGeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGenerateReport(): void
    {
        $reportGenerator = new PayrollReportGenerator(
            new FakeEmploymentRepository(
                new EmployeeDTO(
                    'Adam',
                    'Kowalski',
                    'HR',
                    Money::USD(100000),
                    'permanent',
                    new DateTimeImmutable('2007-01-01'),
                    0
                ),
                new EmployeeDTO(
                    'Adam',
                    'Nowak',
                    'Customer Service',
                    Money::USD(110000),
                    'percentage',
                    new DateTimeImmutable('2017-01-01'),
                    10
                )
            ),
            new RemunerationCalculator(...[new PercentageBonusCalculator(), new PermanentBonusCalculator()]),
            new FakeClock(new DateTimeImmutable('2022-01-10'))
        );

        $report = $reportGenerator->generate(new PayrollReportQuery());

        self::assertEquals(
            $report,
            [
                new ReportRowDTO(
                    'Adam',
                    'Kowalski',
                    'HR',
                    Money::USD(100000),
                    Money::USD(100000),
                    'permanent',
                    Money::USD(200000)
                ),
                new ReportRowDTO(
                    'Adam',
                    'Nowak',
                    'Customer Service',
                    Money::USD(110000),
                    Money::USD(11000),
                    'percentage',
                    Money::USD(121000)
                ),
            ]
        );
    }
}
