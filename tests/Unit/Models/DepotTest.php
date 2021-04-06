<?php

namespace Tests\Unit\Models;

use Tests\Helpers\TestDataCreator;
use Tests\TestCase;
use App\Models\Depot;
use App\Models\User;
use App\Models\Stock;

class DepotTest extends TestCase
{
    use TestDataCreator;

    public function testDepotBelongsToUser()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(User::class, $depot->user);
    }

    public function testDepotBelongsToManyStocks()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $stock = factory(Stock::class)->create();

        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.77, 6)
        );

        $this->assertInstanceOf(Stock::class, $depot->stocks->first());
    }
}
