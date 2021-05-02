<?php

namespace App\Services\YahooFinance;

use App\Data\CacheKeys;
use App\Data\YahooFinance;
use App\Exceptions\InvalidApiCallException;
use App\Models\Stock;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class FinancialConnector implements ConnectorInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * FinancialConnector constructor.
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
            $this->addToCache($stock, $decodedResult);
            return $decodedResult;
        } else {
            throw new InvalidApiCallException();
        }
    }

    protected function getKey(Stock $stock)
    {
        return CacheKeys::FINANCIAL . $stock->ticker_symbol;
    }

    protected function addToCache(Stock $stock, object $result)
    {
        Cache::add(
            $this->getKey($stock),
            $result,
            Carbon::now()->addMinutes(10)
        );
    }
}
