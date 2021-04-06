<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use App\Traits\DateFormatter;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotFinancialsControllerTest extends TestCase
{
    use DateFormatter;
    use WithFaker;

    public function testDepotCallMustBeAuthenticated()
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

        $stock = factory(Stock::class)->create(
            [
                'name' => $this->faker->name,
                'wkn_number' => $this->faker->randomNumber(6),
                'ticker_symbol' => 'TSLA'
            ]
        );

        $depot->stocks()->attach($stock, [
            'buy_price' => 6.00,
            'buy_currency' => 'Euro',
            'buy_date' => $this->formatDate('05/06/2020'),
            'quantity' => 6
        ]);

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
