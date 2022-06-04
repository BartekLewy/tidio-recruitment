<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\ReadModel;

use Money\Money;
use Payroll\PayrollReport\DomainModel\Calculator\RemunerationCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PercentageBonusCalculator;
use Payroll\PayrollReport\DomainModel\Calculator\Strategy\PermanentBonusCalculator;
use Payroll\PayrollReport\ReadModel\Employee\EmployeeDTO;
use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use Payroll\PayrollReport\ReadModel\PayrollReportGeneratorWithFullSort;
use Payroll\PayrollReport\ReadModel\PayrollReportQuery;
use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;
use PHPUnit\Framework\TestCase;

class PayrollReportGeneratorWithFullSortTest extends TestCase
{
    private PayrollReportGeneratorWithFullSort $systemUnderTest;

    public function setUp(): void
    {
        $this->systemUnderTest = new PayrollReportGeneratorWithFullSort(
            new PayrollReportGenerator(
                new FakeEmploymentRepository(
                    new EmployeeDTO(
                        'Increase',
                        'Test',
                        'HR',
                        Money::USD(200000),
                        'permanent',
                        new \DateTimeImmutable('2007-01-01'),
                        0
                    ),
                    new EmployeeDTO(
                        'Adam',
                        'Kowalski',
                        'HR',
                        Money::USD(100000),
                        'permanent',
                        new \DateTimeImmutable('2007-01-01'),
                        0
                    ),
                    new EmployeeDTO(
                        'Adam',
                        'Nowak',
                        'Customer Service',
                        Money::USD(110000),
                        'percentage',
                        new \DateTimeImmutable('2017-01-01'),
                        10
                    )
                ),
                new RemunerationCalculator(...[new PercentageBonusCalculator(), new PermanentBonusCalculator()]),
                new FakeClock(new \DateTimeImmutable()),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getSortedCollection
     */
    public function shouldSortAccordingToGivenQuery(array $query, callable $extractor, array $expected): void
    {
        $sortedReport = $this->systemUnderTest->generate(
            PayrollReportQuery::fromArray($query)
        );

        self::assertEquals(
            $expected,
            array_map($extractor, $sortedReport)
        );
    }

    public function getSortedCollection(): array
    {
        return [
            'Sort ascending order by full remuneration' => [
                [
                    'sort' => [
                        'fullRemuneration' => 'ASC',
                        
                    ], ],
                static fn (ReportRowDTO $row): \Money\Money => $row->getFullRemuneration(),
                [Money::USD(121000), Money::USD(200000), Money::USD(300000)],
            ],
            'Sort descending order by full remuneration' => [
                [
                    'sort' => [
                        'fullRemuneration' => 'DESC',
                        
                    ], ],
                static fn (ReportRowDTO $row): \Money\Money => $row->getFullRemuneration(),
                [Money::USD(300000), Money::USD(200000), Money::USD(121000)],
            ],
            'Sort ascending order by additional remuneration' => [
                [
                    'sort' => [
                        'additionalRemuneration' => 'ASC',
                        
                    ], ],
                static fn (ReportRowDTO $row): \Money\Money => $row->getAdditionalRemuneration(),
                [Money::USD(11000), Money::USD(100000), Money::USD(100000)],
            ],
            'Sort descending order by additional remuneration' => [
                [
                    'sort' => [
                        'additionalRemuneration' => 'DESC',
                        
                    ], ],
                static fn (ReportRowDTO $row): \Money\Money => $row->getAdditionalRemuneration(),
                [Money::USD(100000), Money::USD(100000), Money::USD(11000)],
            ],
        ];
    }
}
