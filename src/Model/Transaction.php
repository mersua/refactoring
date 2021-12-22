<?php

declare(strict_types=1);

namespace App\Model;

class Transaction implements Model
{
    private int $bin;
    private float $amount;
    private string $currency;

    public function getBin(): int
    {
        return $this->bin;
    }

    public function setBin(int $bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public static function fromOrigin(array $origin): self
    {
        return (new self())
            ->setBin((int) $origin['bin'])
            ->setAmount((float) $origin['amount'])
            ->setCurrency((string) $origin['currency']);
    }
}