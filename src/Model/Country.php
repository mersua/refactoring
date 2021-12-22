<?php

declare(strict_types=1);

namespace App\Model;

class Country implements Model
{
    const EU_COUNTRY_CODES = [
        'AT' => 'Austria',
        'BE' => 'Belgium',
        'BG' => 'Bulgaria',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DE' => 'Germany',
        'DK' => 'Denmark',
        'EE' => 'Estonia',
        'ES' => 'Spain',
        'FI' => 'Finland',
        'FR' => 'France',
        'GB' => 'United Kingdom',
        'GR' => 'Greece',
        'HU' => 'Hungary',
        'HR' => 'Croatia',
        'IE' => 'Ireland, Republic of (EIRE)',
        'IT' => 'Italy',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'LV' => 'Latvia',
        'MT' => 'Malta',
        'NL' => 'Netherlands',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'RO' => 'Romania',
        'SE' => 'Sweden',
        'SI' => 'Slovenia',
        'SK' => 'Slovakia',
    ];

    private string $name;
    private string $code;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public static function fromOrigin(array $origin): self
    {
        return (new self())
            ->setCode($origin['alpha2'])
            ->setName($origin['name']);
    }

    public function isEu(): bool
    {
        return array_key_exists($this->code, self::EU_COUNTRY_CODES);
    }
}