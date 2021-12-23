<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Model\Country;
use GuzzleHttp\Exception\GuzzleException;

class CountryClient extends Client
{
    private int $bin = 0;

    public function __construct()
    {
        $this->baseUrl = $_ENV['BINLIST_BASE_URL'];
    }

    public function getBin(): int
    {
        return $this->bin;
    }

    public function setBin(int $bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function fetch(): Country
    {
        if (!$this->getBin()) {
            throw new \Exception('Bin value was not set');
        }

        $response = $this->getClient()->get($this->baseUrl . $this->bin);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Invalid response code %d for \'Country\' client', $response->getStatusCode()));
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return Country::fromOrigin($data['country']);
    }
}