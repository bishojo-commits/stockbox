<?php

namespace App\Http\Controllers\YahooFinance;

use App\Models\Depot;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Traits\RelationComposer;
use App\Transformers\HistoricalDataTransformer;
use App\Services\YahooFinance\ConnectorInterface;

class StockHistoricalController extends Controller
{
    use RelationComposer;

    /**
     * @var ConnectorInterface
     */
    protected $historical;

    /**
     * StockHistoricalController constructor.
     * @param ConnectorInterface $historical
     */
    public function __construct(ConnectorInterface $historical)
    {
        $this->middleware(['auth:sanctum']);
        $this->historical = $historical;
    }

    public function historical(string $depotId, string $stockId)
    {
        $depot = Depot::find($depotId);
        $stock = Stock::find($stockId);
        $stock = $this->loadPivot($depot, $stock);

        $result = $this->historical->callApi($stock);

        return fractal()
            ->item($result)
            ->transformWith(new HistoricalDataTransformer($stock));
    }
}
