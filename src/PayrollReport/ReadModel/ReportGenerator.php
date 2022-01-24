<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\ReadModel;

use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;

interface ReportGenerator
{
    /**
     * @return ReportRowDTO[]
     */
    public function generate(PayrollReportQuery $query): array;
}
