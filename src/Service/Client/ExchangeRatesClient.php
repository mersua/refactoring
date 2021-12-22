<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Model\ExchangeRates;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRatesClient extends Client
{
    private string $accessKey;

    public function __construct()
    {
        $this->baseUrl = $_ENV['EXCHANGE_RATES_BASE_URL'];
        $this->accessKey = $_ENV['EXCHANGE_RATES_ACCESS_KEY'];
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function fetch(): ExchangeRates
    {
        $url = $this->baseUrl . 'latest?' . http_build_query([
            'access_key' => $this->accessKey,
            'format' => 1,
        ]);

        $response = $this->getClient()->get($url);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Invalid response code %d for \'ExchangeRates\' client', $response->getStatusCode()));
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return ExchangeRates::fromOrigin($data);
    }
}