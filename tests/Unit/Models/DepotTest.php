<?php

namespace Tests\Unit\Models;

use Illuminate\Support\Carbon;
use Tests\TestCase;
use App\Models\Depot;
use App\Models\User;
use App\Models\Stock;

class DepotTest extends TestCase
{
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

        $depot->stocks()->attach($stock,
            [
                'buy_price' => 6.77,
                'buy_date' => Carbon::createFromFormat('m/d/Y', '05/20/2020')->format('Y-m-d'),
                'buy_currency' => 'EUR',
                'quantity' => 6
            ]
        );

        $this->assertInstanceOf(Stock::class, $depot->stocks->first());
    }
}
