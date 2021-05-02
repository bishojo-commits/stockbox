<?php

namespace Tests\Feature\YahooFinance;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class StockSummaryControllerTest extends TestCase
{
    use TestDataCreator;

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
        $stock = $this->createStock('test');

        $this->actingAs($user)
            ->get(route('stock.summary', $stock->id))
            ->assertJsonFragment(['symbol' => 'TEST']);
    }
}
