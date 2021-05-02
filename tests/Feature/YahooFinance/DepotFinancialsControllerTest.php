<?php

namespace Tests\Feature\YahooFinance;

use App\Data\CacheKeys;
use App\Models\Depot;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class DepotFinancialsControllerTest extends TestCase
{
    use TestDataCreator;

    public function testDepotTotalCallMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->get(route(
            'depot.depotTotal',
            [
                'depotId' => $depot->id
            ]
        ))
            ->assertRedirect('/login');
    }

    public function testDepotTotalContainsJsonStructure()
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
                'depot.depotTotal',
                [
                'depotId' => $depot->id
                ]
            ))
            ->assertJsonStructure(['data' => ['depotTotal']]);
    }

    public function testFinancialsApiCallServerCached()
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
                'depot.depotTotal',
                [
                    'depotId' => $depot->id
                ]
            ));

        $this->assertNotEmpty(Cache::get(CacheKeys::FINANCIAL . 'TSLA'));
    }
}
