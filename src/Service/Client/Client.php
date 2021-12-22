<?php

declare(strict_types=1);

namespace App\Service\Client;

use App\Model\Model;
use GuzzleHttp\Client as GuzzleClient;

abstract class Client
{
    protected ?GuzzleClient $client = null;
    protected string $baseUrl = '';

    protected function getClient(): GuzzleClient
    {
        if ($this->client === null) {
            $this->client = new GuzzleClient();
        }

        return $this->client;
    }

    abstract protected function fetch(): Model;
}