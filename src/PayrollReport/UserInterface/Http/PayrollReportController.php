<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\UserInterface\Http;

use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PayrollReportController
{
    private PayrollReportGenerator $payrollReportGenerator;

    public function __construct(PayrollReportGenerator $payrollReportGenerator)
    {
        $this->payrollReportGenerator = $payrollReportGenerator;
    }

    public function generate(): JsonResponse
    {
        $result = [];

        return new JsonResponse($result, $result != [] ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NO_CONTENT);
    }
}