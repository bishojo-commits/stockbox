<?php

namespace App\Services\YahooFinance;

use GuzzleHttp\Client;
use App\Data\YahooFinance;
use App\Models\Stock;

class HistoricalRequest implements RequestInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * HistoricalRequest constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function callApi(Stock $stock)
    {
        $result = $this->client->get(
            YahooFinance::API_BASE_URL.YahooFinance::STOCK_HISTORICAL.$stock->ticker_symbol,
            [
                'headers' => [
                    'x-rapidapi-host' => env(YahooFinance::API_HOST_ENV),
                    'x-rapidapi-key' => env(YahooFinance::API_KEY_ENV)
                ]
            ]
        );

        return json_decode($result->getBody());
    }
}
