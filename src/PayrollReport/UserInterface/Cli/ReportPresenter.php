<?php

declare(strict_types=1);

namespace Payroll\PayrollReport\UserInterface\Cli;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Payroll\PayrollReport\ReadModel\Report\ReportRowDTO;

class ReportPresenter
{
    /** @var ReportRowDTO[] */
    private array $rows;

    public function __construct(ReportRowDTO ...$rows)
    {
        $this->rows = $rows;
    }

    public function present(): array
    {
        $self = $this;

        return array_map(
            static function (ReportRowDTO $row) use ($self): array {
                return [
                    'firstName' => $row->getFirstName(),
                    'lastName' => $row->getLastName(),
                    'department' => $row->getDepartment(),
                    'basisOfRemuneration' => $self->formatMoney($row->getBasisOfRemuneration()),
                    'additionalRemuneration' => $self->formatMoney($row->getAdditionalRemuneration()),
                    'bonusType' => $row->getBonusType(),
                    'fullRemunertaion' => $self->formatMoney($row->getFullRemuneration()),
                ];
            },
            $this->rows
        );
    }

    private function formatMoney(Money $money): string
    {
        $currencies = new ISOCurrencies();

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}