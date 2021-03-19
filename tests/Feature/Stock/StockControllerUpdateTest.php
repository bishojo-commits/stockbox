<?php

namespace Tests\Feature\Stock;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use App\Traits\DateFormatter;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerUpdateTest extends TestCase
{
    use DateFormatter, WithFaker;

    public function testUpdateRouteMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $stock = factory(Stock::class)->create();

        $this->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertRedirect('/login');
    }

    public function testUpdateRouteRequiresStockName()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['name']);
    }

    public function testUpdateRouteRequiresWknNumber()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['wkn_number']);
    }

    public function testUpdateRouteRequiresTickerSymbol()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['ticker_symbol']);
    }

    public function testUpdateRouteRequiresBuyPrice()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['buy_price']);
    }

    public function testUpdateRouteRequiresBuyCurrency()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['buy_currency']);
    }

    public function testUpdateRouteRequiresBuyDate()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['buy_date']);
    }

    public function testUpdateRouteRequiresQuantity()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();
        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertSessionHasErrors(['quantity']);
    }

    public function testUpdateRouteOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();
        $depot->stocks()->attach($stock, $pivot = [
            'buy_price' => 6.00,
            'buy_currency' => 'Euro',
            'buy_date' => $this->formatDate('05/06/2020'),
            'quantity' => 6
        ]);

        $this->actingAs($user)->patch(route('stock.update', [
            'depot' => $depot, 'stock' => $stock
        ]), [
            'name' => $this->faker->word,
            'wkn_number' => $this->faker->randomNumber(6),
            'ticker_symbol' => $this->faker->randomNumber(3),
            'buy_price' => $price = 10.00,
            'buy_currency' => $this->faker->currencyCode,
            'buy_date' => '06/07/2020',
            'quantity' => 4
        ]);

        $this->assertDatabaseHas('depot_stock', ['buy_price' => $price]);
    }
}
