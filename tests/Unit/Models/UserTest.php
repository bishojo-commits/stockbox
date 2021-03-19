<?php

namespace Tests\Unit\Models;

use Illuminate\Support\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Depot;
use App\Models\Stock;

class UserTest extends TestCase
{
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

        $depot->stocks()->attach($stock,
            [
                'buy_price' => 6.77,
                'buy_date' => Carbon::createFromFormat('m/d/Y', '05/20/2020')->format('Y-m-d'),
                'buy_currency' => 'EUR',
                'quantity' => 6
            ]
        );

        $this->assertInstanceOf(Stock::class, $user->depot->stocks->first());
    }
}
