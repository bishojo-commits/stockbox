<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Depot;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class StockHistoricalControllerTest extends TestCase
{
    use WithFaker;
    use TestDataCreator;

    public function testApiCallMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createStock('TSLA');
        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.00, 6)
        );

        $this->get(route(
            'stock.historical',
            [
                'depotId' => $depot->id,
                'stockId' =>  $stock->id
            ]
        ))
            ->assertRedirect('/login');
    }

    public function testApiCallOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $this->createStock('TSLA');
        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.00, 6)
        );

        $this->actingAs($user)
            ->get(route(
                'stock.historical',
                [
                    'depotId' => $depot->id,
                    'stockId' => $stock->id
                ]
            ))
            ->assertOk();
    }

    public function testApiCallUrlGenerationException()
    {
        $this->expectException(UrlGenerationException::class);

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route(
                'stock.historical',
                []
            ));
    }

    public function testApiCallContainsFormattedData()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = $stock = $this->createStock('TSLA');
        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.00, 6)
        );

        $this->actingAs($user)
            ->get(route('stock.historical', [$depot->id, $stock->id]))
            ->assertJson(['data' => []]);
    }
}
