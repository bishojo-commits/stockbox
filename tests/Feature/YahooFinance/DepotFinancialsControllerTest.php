<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Depot;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class DepotFinancialsControllerTest extends TestCase
{
    use TestDataCreator;
    use WithFaker;

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
}
