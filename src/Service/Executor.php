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
    public static function execute(string $inputFile): array
    {
        $exchangeRates = (new ExchangeRatesClient())->fetch();
        $transactionReader = new TransactionReader($inputFile);

        $commissions = [];
        foreach ($transactionReader->process() as $transaction) {
            $country = (new CountryClient($transaction->getBin()))->fetch();
            $commission = new Commission($transaction, $country, $exchangeRates);
            $commission->calculate();
            $commissions[] = $commission;
        }

        return $commissions;
    }
}