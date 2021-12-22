<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Transaction;

class TransactionReader
{
    private string $inputFile;

    public function __construct(string $inputFile)
    {
        $this->inputFile = $inputFile;
    }

    private function readTransactions(): array
    {
        if (!($file = fopen($this->inputFile, 'r'))) {
            throw new \RuntimeException(sprintf('Failed to open filepath %s', $this->inputFile));
        }

        $transactions = [];
        while ($line = fgets($file)) {
            $transactions[] = json_decode($line, true);
        }

        return $transactions;
    }

    /**
     * @throws \Exception
     */
    public function process(): iterable
    {
        foreach ($this->readTransactions() as $transaction) {
            yield Transaction::fromOrigin($transaction);
        }
    }
}