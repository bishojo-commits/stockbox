<?php

namespace App\Http\Controllers\YahooFinance;

use App\Http\Controllers\Controller;
use App\Models\Depot;
use App\Services\YahooFinance\ConnectorInterface;
use App\Transformers\DepotTotalTransformer;

class DepotFinancialsController extends Controller
{
    /**
     * @var ConnectorInterface
     */
    protected $financials;

    /**
     * DepotFinancialsController constructor.
     * @param ConnectorInterface $financials
     */
    public function __construct(ConnectorInterface $financials)
    {
        $this->middleware(['auth:sanctum']);
        $this->financials = $financials;
    }

    public function depotTotal(string $depotId)
    {
        $result = [];
        $stocks = Depot::find($depotId)->stocks;

        foreach ($stocks as $stock) {
            $result[] = $this->financials->callApi($stock);
        }

        return fractal()
            ->item($result)
            ->transformWith(new DepotTotalTransformer($stocks));
    }
}
