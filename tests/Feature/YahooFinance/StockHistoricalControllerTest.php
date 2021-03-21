<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use App\Traits\DateFormatter;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockHistoricalControllerTest extends TestCase
{
    use WithFaker;
    use DateFormatter;

    public function testApiCallMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = factory(Stock::class)->create();
        $depot->stocks()->attach($stock, [
            'buy_price' => 6.00,
            'buy_currency' => 'Euro',
            'buy_date' => $this->formatDate('05/06/2020'),
            'quantity' => 6
        ]);

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
                'stock.historical',
                [
                    'depotId' => $depot->id,
                    'stockId' => $stock->id
                ]
            ))
            ->assertOk();
    }

    public function testApiCallContainsFormattedData()
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
            ->get(route('stock.statistics', [$depot->id, $stock->id]))
            ->assertJsonFragment(['symbol' => 'TSLA']);
    }
}
