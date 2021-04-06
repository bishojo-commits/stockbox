<?php

namespace Tests\Unit\Models;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use Tests\TestCase;
use Tests\Helpers\TestDataCreator;

class StockTest extends TestCase
{
    use TestDataCreator;

    public function testManyDepotsBelongToStock()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $stock = factory(Stock::class)->create();

        $stock->depots()->attach(
            $depot,
            $this->createStockPivotData(6.77, 6)
        );

        $this->assertInstanceOf(Depot::class, $stock->depots->first());
    }
}
