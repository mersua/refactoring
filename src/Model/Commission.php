<?php

declare(strict_types=1);

namespace App\Model;

class Commission
{
    const EU_BASED_RATE = 0.01;
    const NOT_EU_BASED_RATE = 0.02;

    private Transaction $transaction;
    private Country $country;
    private ExchangeRates $exchangeRates;
    private float $value;

    public function __construct(Transaction $transaction, Country $country, ExchangeRates $exchangeRates)
    {
        $this->transaction = $transaction;
        $this->country = $country;
        $this->exchangeRates = $exchangeRates;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getExchangeRates(): ExchangeRates
    {
        return $this->exchangeRates;
    }

    public function setExchangeRates(ExchangeRates $exchangeRates): self
    {
        $this->exchangeRates = $exchangeRates;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function calculate(): float
    {
        $rate = $this->exchangeRates->getRateByCurrency($this->getTransaction()->getCurrency());
        $amount = $this->getTransaction()->getAmount() / $rate;

        $value = $this->getCountry()->isEu() ? $amount * self::EU_BASED_RATE : $amount * self::NOT_EU_BASED_RATE;
        $value = $this->valueCeiling($value);

        $this->setValue($value);

        return $value;
    }

    private function valueCeiling(float $value): float
    {
        return ceil($value * 100) / 100;
    }
}