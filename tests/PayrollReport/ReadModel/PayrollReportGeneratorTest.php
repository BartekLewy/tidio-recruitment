<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

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
                    new \DateTimeImmutable('2007-01-01')
                ),
                new EmployeeDTO(
                    'Adam',
                    'Nowak',
                    'Customer Service',
                    Money::USD(110000),
                    'percentage',
                    new \DateTimeImmutable('2017-01-01')
                )
            ),
            new RemunerationCalculator(...[new PercentageBonusCalculator(), new PermanentBonusCalculator()])
        );

        $query = new PayrollReportQuery();
        $query->setGenerationDate(new \DateTimeImmutable('2022-01-10'));

        $report = $reportGenerator->generate($query);

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
