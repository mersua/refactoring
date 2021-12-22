<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Model\Country;
use GuzzleHttp\Exception\GuzzleException;

class CountryClient extends Client
{
    private int $bin;

    public function __construct(int $bin)
    {
        $this->baseUrl = $_ENV['BINLIST_BASE_URL'];
        $this->bin = $bin;
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function fetch(): Country
    {
        $response = $this->getClient()->get($this->baseUrl . $this->bin);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Invalid response code %d for \'Country\' client', $response->getStatusCode()));
        }

        $data = json_decode($response->getBody()->getContents(), true);

        return Country::fromOrigin($data['country']);
    }
}