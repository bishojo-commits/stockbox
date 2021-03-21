<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockSummaryControllerTest extends TestCase
{
    use WithFaker;

    public function testApiCallMustBeAuthenticated()
    {
        $stock = factory(Stock::class)->create();

        $this->get(route('stock.summary', $stock->id))
            ->assertRedirect('/login');
    }

    public function testApiCallOk()
    {
        $user = factory(User::class)->create();
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)
            ->get(route('stock.summary', $stock->id))
            ->assertOk();
    }

    public function testApiCallContainsFormattedData()
    {
        $user = factory(User::class)->create();
        $stock = factory(Stock::class)->create([
            'name' => $this->faker->name,
            'wkn_number' => $this->faker->randomNumber(6),
            'ticker_symbol' => 'test'
        ]);

        $this->actingAs($user)
            ->get(route('stock.summary', $stock->id))
            ->assertJsonFragment(['symbol' => 'TEST']);
    }
}
