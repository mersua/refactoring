<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Commission;
use App\Service\Client\CountryClient;
use App\Service\Client\ExchangeRatesClient;

class Executor
{
    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function execute(
        TransactionReader $reader,
        ExchangeRatesClient $ratesClient,
        CountryClient $countryClient
    ): array {
        $exchangeRates = $ratesClient->fetch();

        $commissions = [];
        foreach ($reader->process() as $transaction) {
            $country = $countryClient->setBin($transaction->getBin())->fetch();
            $commission = new Commission($transaction, $country, $exchangeRates);
            $commission->calculate();
            $commissions[] = $commission;
        }

        return $commissions;
    }
}