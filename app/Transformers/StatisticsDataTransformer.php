<?php

namespace App\Transformers;

use App\Models\Stock;
use League\Fractal\TransformerAbstract;

class StatisticsDataTransformer extends TransformerAbstract
{
    /**
     * @var Stock
     */
    protected $stock;

    /**
     * StatisticsDataTransformer constructor.
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
     * @return array
     */
    public function transform($result)
    {
        return [
            'statistics' => $result
        ];
    }
}
