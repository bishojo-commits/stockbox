<?php

namespace App\Http\Controllers\YahooFinance;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\YahooFinance\ConnectorInterface;
use App\Transformers\StatisticsDataTransformer;

class StockStatisticsController extends Controller
{
    /**
     * @var ConnectorInterface
     */
    protected $statistics;

    /**
     * StockStatisticsController constructor.
     * @param ConnectorInterface $statistics
     */
    public function __construct(ConnectorInterface $statistics)
    {
        $this->middleware(['auth:sanctum']);
        $this->statistics = $statistics;
    }

    public function statistics(string $stockId)
    {
        $stock = Stock::find($stockId);

        $result = $this->statistics->callApi($stock);

        return fractal()
            ->item($result)
            ->transformWith(new StatisticsDataTransformer($stock));
    }
}
