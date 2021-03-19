<?php

namespace App\Traits;

use App\Models\Depot;
use App\Models\Stock;

trait RelationComposer
{
    protected function loadPivot(Depot $depot, Stock $stock)
    {
        foreach ($depot->stocks as $depotStock) {
            if ($depotStock->id === $stock->id) {
                return $depotStock;
            }
        }
    }
}
