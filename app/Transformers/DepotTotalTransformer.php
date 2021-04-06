<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class DepotTotalTransformer extends TransformerAbstract
{
    /**
     * @var Collection
     */
    protected $stocks;

    /**
     * DepotTotalTransformer constructor.
     * @param Collection $stocks
     */
    public function __construct(Collection $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * @param $result
     * @return array
     */
    public function transform($result)
    {
        $depotTotal = 0.00;

        foreach ($result as $financialData) {
            $symbol = $financialData->meta->symbol;

            foreach ($this->stocks as $stock) {
                if ($stock->ticker_symbol === $symbol) {
                    $depotTotal += $financialData->price->regularMarketOpen->raw * $stock->pivot->quantity;
                }
            }
        }

        return [
            'depotTotal' => $depotTotal
        ];
    }
}
