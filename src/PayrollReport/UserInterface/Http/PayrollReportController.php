<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\UserInterface\Http;

use Payroll\PayrollReport\ReadModel\Exception\InvalidArgumentException;
use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use Payroll\PayrollReport\ReadModel\PayrollReportQuery;
use Payroll\PayrollReport\UserInterface\ReportPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PayrollReportController
{
    private PayrollReportGenerator $payrollReportGenerator;

    public function __construct(PayrollReportGenerator $payrollReportGenerator)
    {
        $this->payrollReportGenerator = $payrollReportGenerator;
    }

    public function generate(Request $request): JsonResponse
    {
        try {
            $query = PayrollReportQuery::fromArray($request->query->all());
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage(), 'code' => $e->getCode()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $report = $this->payrollReportGenerator->generate($query);
        $presenter = new ReportPresenter(...$report);

        return new JsonResponse($presenter->present());
    }
}