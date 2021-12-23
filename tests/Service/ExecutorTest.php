<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Model\Country;
use App\Model\ExchangeRates;
use App\Service\Client\CountryClient;
use App\Service\Client\ExchangeRatesClient;
use App\Service\Executor;
use App\Service\TransactionReader;
use PHPUnit\Framework\TestCase;

class ExecutorTest extends TestCase
{
    const INPUT_FILE = __DIR__ . '/../../data/input.txt';
    const COUNTRY_MOCK_FILE = __DIR__ . '/../../data/country.mock.txt';
    const EXCHANGE_RATES_MOCK_FILE = __DIR__ . '/../../data/exchange-rates.mock.txt';

    private Country $countryMock1;
    private Country $countryMock2;
    private Country $countryMock3;
    private Country $countryMock4;
    private Country $countryMock5;
    private ExchangeRates $exchangeRatesMock;

    private TransactionReader $transactionReaderMock;
    private ExchangeRatesClient $exchangeRatesClientMock;
    private CountryClient $countryClientMock;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        $countryDataset = json_decode(file_get_contents(self::COUNTRY_MOCK_FILE), true);

        $this->countryMock1 = Country::fromOrigin($countryDataset[0]);
        $this->countryMock2 = Country::fromOrigin($countryDataset[1]);
        $this->countryMock3 = Country::fromOrigin($countryDataset[2]);
        $this->countryMock4 = Country::fromOrigin($countryDataset[3]);
        $this->countryMock5 = Country::fromOrigin($countryDataset[4]);

        $this->exchangeRatesMock = ExchangeRates::fromOrigin(
            json_decode(file_get_contents(self::EXCHANGE_RATES_MOCK_FILE), true)
        );

        $this->transactionReaderMock = new TransactionReader(self::INPUT_FILE);
        $this->exchangeRatesClientMock = $this->createMock(ExchangeRatesClient::class);
        $this->countryClientMock = $this->createMock(CountryClient::class);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testExecute(): void
    {
        $this->exchangeRatesClientMock->expects($this->once())
            ->method('fetch')
            ->willReturn($this->exchangeRatesMock);

        $this->countryClientMock->expects($this->exactly(5))
            ->method('setBin')
            ->willReturn($this->countryClientMock);

        $this->countryClientMock->expects($this->exactly(5))
            ->method('fetch')
            ->willReturnOnConsecutiveCalls(
                $this->countryMock1,
                $this->countryMock2,
                $this->countryMock3,
                $this->countryMock4,
                $this->countryMock5
            );

        $commissions = Executor::execute(
            $this->transactionReaderMock,
            $this->exchangeRatesClientMock,
            $this->countryClientMock
        );

        $this->assertCount(5, $commissions);

        $this->assertEquals(1, $commissions[0]->getValue());
        $this->assertEquals(0.45, $commissions[1]->getValue());
        $this->assertEquals(1.55, $commissions[2]->getValue());
        $this->assertEquals(2.3, $commissions[3]->getValue());
        $this->assertEquals(23.59, $commissions[4]->getValue());
    }
}