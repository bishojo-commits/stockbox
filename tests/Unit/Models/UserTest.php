<?php

namespace Tests\Unit\Models;

use Tests\Helpers\TestDataCreator;
use Tests\TestCase;
use App\Models\User;
use App\Models\Depot;
use App\Models\Stock;

class UserTest extends TestCase
{
    use TestDataCreator;

    public function testUserHasOneDepot()
    {
        $user = factory(User::class)->create();

        $user->depot()->save(factory(Depot::class)->create([
            'user_id' => $user->id
        ]));

        $this->assertInstanceOf(Depot::class, $user->depot()->first());
    }

    public function testUserHasDepotWithManyStocks()
    {
        $user = factory(User::class)->create();

        $user->depot()->save($depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]));

        $stock = factory(Stock::class)->create();

        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.77, 6)
        );

        $this->assertInstanceOf(Stock::class, $user->depot->stocks->first());
    }
}
