<?php

namespace App\Services\YahooFinance;

use App\Data\YahooFinance;
use App\Exceptions\InvalidApiCallException;
use App\Models\Stock;
use App\Services\Cache\CacheCrud;
use GuzzleHttp\Client;

class FinancialConnector implements ConnectorInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var CacheCrud
     */
    protected $cacheHandler;

    /**
     * FinancialConnector constructor.
     * @param Client $client
     * @param CacheCrud $cacheHandler
     */
    public function __construct(Client $client, CacheCrud $cacheHandler)
    {
        $this->client = $client;
        $this->cacheHandler = $cacheHandler;
    }

    /**
     * @param Stock $stock
     * @return mixed
     * @throws InvalidApiCallException
     */
    public function callApi(Stock $stock)
    {
        $result = $this->client->get(
            YahooFinance::API_BASE_URL . YahooFinance::STOCK_FINANCIALS . $stock->ticker_symbol,
            [
                'headers' => [
                    'x-rapidapi-host' => env(YahooFinance::API_HOST_ENV),
                    'x-rapidapi-key' => env(YahooFinance::API_KEY_ENV)
                ]
            ]
        );

        if ($result->getStatusCode() === 200) {
            $decodedResult = json_decode($result->getBody());
            $this->cacheHandler->add($stock, $decodedResult);

            return $decodedResult;
        } else {
            throw new InvalidApiCallException();
        }
    }
}
