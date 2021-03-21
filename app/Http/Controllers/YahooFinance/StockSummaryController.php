<?php

namespace App\Http\Controllers\YahooFinance;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\YahooFinance\ConnectorInterface;
use App\Transformers\SummaryDataTransformer;

class StockSummaryController extends Controller
{
    /**
     * @var ConnectorInterface
     */
    protected $summary;

    /**
     * StockSummaryController constructor.
     * @param ConnectorInterface $summary
     */
    public function __construct(ConnectorInterface $summary)
    {
        $this->middleware(['auth:sanctum']);
        $this->summary = $summary;
    }

    public function summary(string $stockId)
    {
        $stock = Stock::find($stockId);
        $result = $this->summary->callApi($stock);

        return fractal()
            ->item($result)
            ->transformWith(new SummaryDataTransformer($stock));
    }
}
