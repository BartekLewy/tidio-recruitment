<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\UserInterface\Cli;

use Payroll\PayrollReport\ReadModel\PayrollReportGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeneratePayrollReportCommand extends Command
{
    private PayrollReportGenerator $reportGenerator;

    public function __construct(PayrollReportGenerator $reportGenerator)
    {
        parent::__construct();
        $this->reportGenerator = $reportGenerator;
    }

    protected function configure()
    {
        $this
            ->setName('payroll:report:generate')
            ->setDescription('It generates payroll reports for current month');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $report = $this->reportGenerator->generate(new \DateTimeImmutable());
        $rows = (new ReportPresenter(...$report))->present();

        $table = new Table($output);
        $table->setHeaders(array_keys($rows[0]));
        $table->addRows($rows);
        $table->render();

        return self::SUCCESS;
    }
}