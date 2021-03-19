<?php

namespace Tests\Feature\Stock;

use App\Models\Depot;
use App\Models\User;
use App\Traits\DateFormatter;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerStoreTest extends TestCase
{
    use DateFormatter, WithFaker;

    public function testStoreRouteMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertRedirect('/login');
    }

    public function testStoreRouteRequiresStockName()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['name']);
    }

    public function testStoreRouteRequiresWknNumber()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['wkn_number']);
    }

    public function testStoreRouteRequiresTickerSymbol()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['ticker_symbol']);
    }

    public function testStoreRouteRequiresBuyPrice()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['buy_price']);
    }

    public function testStoreRouteRequiresBuyCurrency()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['buy_currency']);
    }

    public function testStoreRouteRequiresBuyDate()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['buy_date']);
    }

    public function testStoreRouteRequiresQuantity()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]))
            ->assertSessionHasErrors(['quantity']);
    }

    public function testStoreRouteOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->post(route('stock.store', [
            'depot' => $depot
        ]), [
            'name' => $this->faker->word,
            'wkn_number' => $this->faker->randomNumber(6),
            'ticker_symbol' => $this->faker->randomNumber(3),
            'buy_price' => 6.00,
            'buy_currency' => $this->faker->currencyCode,
            'buy_date' => '06/07/2020',
            'quantity' => 4
        ]);

        $this->assertDatabaseCount('depot_stock', 1);
    }
}
