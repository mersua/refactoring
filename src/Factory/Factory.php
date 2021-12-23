<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\Client\CountryClient;
use App\Service\Client\ExchangeRatesClient;
use App\Service\TransactionReader;

class Factory
{
    private TransactionReader $reader;
    private ExchangeRatesClient $ratesClient;
    private CountryClient $countryClient;

    public function getReader(): TransactionReader
    {
        return $this->reader;
    }

    public function getRatesClient(): ExchangeRatesClient
    {
        return $this->ratesClient;
    }

    public function getCountryClient(): CountryClient
    {
        return $this->countryClient;
    }

    public static function run(string $inputFile): self
    {
        $reader = new TransactionReader($inputFile);
        $ratesClient = new ExchangeRatesClient();
        $countryClient = new CountryClient();

        $factory = new Factory();
        $factory->reader = $reader;
        $factory->ratesClient = $ratesClient;
        $factory->countryClient = $countryClient;

        return $factory;
    }
}