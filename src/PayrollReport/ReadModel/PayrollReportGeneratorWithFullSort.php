<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;

class PayrollReportGeneratorWithFullSort implements ReportGenerator
{
    private const ADDITIONAL_REMUNERATION = 'additionalRemuneration';
    private const FULL_REMUNERATION = 'fullRemuneration';
    private const SUPPORTED_FIELDS = [
        self::ADDITIONAL_REMUNERATION,
        self::FULL_REMUNERATION,
    ];

    private ReportGenerator $generator;

    public function __construct(ReportGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return ReportRowDTO[]
     */
    public function generate(PayrollReportQuery $query): array
    {
        $report = $this->generator->generate($query);

        $sort = $query->getSort();
        if ($sort && in_array($sort->getKey(), self::SUPPORTED_FIELDS)) {
            usort(
                $report,
                static function (ReportRowDTO $a, ReportRowDTO $b) use ($sort): int {
                    if ($sort->getKey() == self::ADDITIONAL_REMUNERATION) {
                        return $a->getAdditionalRemuneration() <=> $b->getAdditionalRemuneration();
                    }

                    if ($sort->getKey() == self::FULL_REMUNERATION) {
                        return $a->getFullRemuneration() <=> $b->getFullRemuneration();
                    }
                }
            );
        }

        return $report;
    }
}
