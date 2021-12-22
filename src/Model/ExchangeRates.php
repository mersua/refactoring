<?php

declare(strict_types=1);

namespace App\Model;

class ExchangeRates implements Model
{
    private string $base;
    private \DateTime $date;
    private array $rates = [];

    public function getBase(): string
    {
        return $this->base;
    }

    public function setBase(string $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRates(): array
    {
        return $this->rates;
    }

    public function setRates(array $rates): self
    {
        $this->rates = $rates;

        return $this;
    }

    public function addRate(string $currency, float $rate): self
    {
        $this->rates[$currency] = $rate;

        return $this;
    }

    public function getRateByCurrency(string $currency): float
    {
        $rates = $this->getRates();

        if (array_key_exists($currency, $rates) && $rates[$currency] > 0) {
            return $rates[$currency];
        }

        throw new \RuntimeException(sprintf('Invalid rate value for currency %s', $currency));
    }

    /**
     * @throws \Exception
     */
    public static function fromOrigin(array $origin): self
    {
        $rates = (new self())
            ->setBase($origin['base'])
            ->setDate(new \DateTime($origin['date']));

        foreach ($origin['rates'] as $currency => $rate) {
            $rates->addRate($currency, (float) $rate);
        }

        return $rates;
    }
}