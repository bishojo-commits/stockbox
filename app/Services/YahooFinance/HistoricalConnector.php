<?php

namespace App\Services\YahooFinance;

use App\Exceptions\InvalidApiCallException;
use GuzzleHttp\Client;
use App\Data\YahooFinance;
use App\Models\Stock;

class HistoricalConnector implements ConnectorInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * HistoricalConnector constructor.
     * @param $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Stock $stock
     * @return mixed
     * @throws InvalidApiCallException
     */
    public function callApi(Stock $stock)
    {
        $result = $this->client->get(
            YahooFinance::API_BASE_URL . YahooFinance::STOCK_HISTORICAL . $stock->ticker_symbol,
            [
                'headers' => [
                    'x-rapidapi-host' => env(YahooFinance::API_HOST_ENV),
                    'x-rapidapi-key' => env(YahooFinance::API_KEY_ENV)
                ]
            ]
        );

        if ($result->getStatusCode() === 200) {
            return json_decode($result->getBody());
        } else {
            throw new InvalidApiCallException();
        }
    }
}
