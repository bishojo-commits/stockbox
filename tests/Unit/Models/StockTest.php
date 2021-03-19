<?php

namespace Tests\Unit\Models;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StockTest extends TestCase
{
    public function testManyDepotsBelongToStock()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $stock = factory(Stock::class)->create();

        $stock->depots()->attach($depot,
            [
                'buy_price' => 6.77,
                'buy_date' => Carbon::createFromFormat('m/d/Y', '05/20/2020')->format('Y-m-d'),
                'buy_currency' => 'EUR',
                'quantity' => 6
            ]
        );

        $this->assertInstanceOf(Depot::class, $stock->depots->first());
    }
}
