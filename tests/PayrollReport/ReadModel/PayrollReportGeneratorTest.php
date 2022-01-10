<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\RemunerationCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PercentageBonusCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PermanentBonusCalculator;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
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
                    Money::USD(1000),
                    'permanent',
                    new \DateTimeImmutable('2007-01-01')
                ),
                new EmployeeDTO(
                    'Adam',
                    'Nowak',
                    'Customer Service',
                    Money::USD(1100),
                    'percentage',
                    new \DateTimeImmutable('2017-01-01')
                )
            ),
            new RemunerationCalculator(...[new PercentageBonusCalculator(), new PermanentBonusCalculator()])
        );

        $report = $reportGenerator->generate(new \DateTimeImmutable('2022-01-10'));

        self::assertEquals(
            $report,
            [
                new ReportRowDTO(
                    'Adam',
                    'Kowalski',
                    'HR',
                    Money::USD(1000),
                    Money::USD(1000),
                    'permanent',
                    Money::USD(2000)
                ),
                new ReportRowDTO(
                    'Adam',
                    'Nowak',
                    'Customer Service',
                    Money::USD(1100),
                    Money::USD(110),
                    'percentage',
                    Money::USD(1210)
                ),
            ]
        );
    }
}
