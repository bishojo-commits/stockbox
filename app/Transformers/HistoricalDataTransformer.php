<?php

namespace App\Transformers;

use App\Traits\DateFormatter;
use League\Fractal\TransformerAbstract;
use App\Models\Stock;

class HistoricalDataTransformer extends TransformerAbstract
{
    use DateFormatter;

    /**
     * @var Stock
     */
    protected $stock;

    /**
     * HistoricalDataTransformer constructor.
     * @param Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
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
     * A Fractal transformer.
     *
     * @param $result
     * @return array
     */
    public function transform($result)
    {
        return [
            'historical' => $this->proccess($result)
        ];
    }

    /**
     * slice result from stock buy date
     *
     * @param $result
     * @return mixed
     */
    protected function proccess($result)
    {
        $timestamp = strtotime($this->stock->pivot->buy_date);
        //ToDo implement Array Filter
        foreach ($result->prices as $key => $item) {
            if ($this->formatTimestamp($item->date) === $this->formatTimestamp($timestamp)) {
                $index = $key;
            }
        }

        return array_slice($result->prices, 0, $index);
    }
}
