<?php

namespace App\Http\Controllers\YahooFinance;

use App\Data\YahooFinance;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StockStatisticsController extends Controller
{
    /**
     * StockStatisticsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function statistics(string $stockId)
    {
        $stock = Stock::find($stockId);
        $client = new Client();

        $result = $client->get(
            YahooFinance::API_BASE_URL . YahooFinance::STOCK_STATISTICS . $stock->ticker_symbol,
            [
                'headers' => [
                    'x-rapidapi-host' => env(YahooFinance::API_HOST_ENV),
                    'x-rapidapi-key' => env(YahooFinance::API_KEY_ENV)
                ]
            ]
        );

        return Response::json(json_decode($result->getBody()));
    }
}
