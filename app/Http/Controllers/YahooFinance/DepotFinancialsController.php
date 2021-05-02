<?php

namespace App\Http\Controllers\YahooFinance;

use App\Data\CacheKeys;
use App\Http\Controllers\Controller;
use App\Models\Depot;
use App\Services\YahooFinance\ConnectorInterface;
use App\Transformers\DepotTotalTransformer;
use Illuminate\Support\Facades\Cache;

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
            $key = CacheKeys::FINANCIAL . $stock->ticker_symbol;

            if (Cache::has($key)) {
                $result[] = Cache::get($key);
            }

            $result[] = $this->financials->callApi($stock);
        }

        return fractal()
            ->item($result)
            ->transformWith(new DepotTotalTransformer($stocks));
    }
}
