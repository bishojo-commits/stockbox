<?php

namespace Tests\Feature\Stock;

use App\Models\Depot;
use App\Models\Stock;
use App\Models\User;
use Tests\Helpers\TestDataCreator;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use TestDataCreator;

    public function testShowRouteMustBeAuthenicated()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);
        $stock = factory(Stock::class)->create();

        $this->get(route('stock.show', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertRedirect('/login');
    }

    public function testShowRouteOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);
        $stock = factory(Stock::class)->create();
        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.00, 6)
        );

        $this->actingAs($user)->get(route('stock.show', [
            'depot' => $depot, 'stock' => $stock
        ]))
            ->assertStatus(200);
    }

    public function testCreateRouteMustBeAuthenticated()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->get(route('stock.create', ['depot' => $depot]))
            ->assertRedirect('/login');
    }

    public function testCreateRouteOk()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => $user = factory(User::class)->create()
        ]);

        $this->actingAs($user)
            ->get(route('stock.create', ['depot' => $depot]))
            ->assertStatus(200);
    }

    public function testDestroyRouteMustBeAuthenticated()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => (factory(User::class)->create())->id
        ]);

        $this->delete(route('stock.destroy', $depot))
            ->assertRedirect('/login');
    }

    public function testDestroyRouteOk()
    {
        $depot = factory(Depot::class)->create([
            'user_id' => ($user = factory(User::class)->create())->id
        ]);

        $stock = factory(Stock::class)->create();
        $depot->stocks()->attach(
            $stock,
            $this->createStockPivotData(6.00, 6)
        );

        $this->actingAs($user)
            ->delete(route('stock.destroy', $depot));

        $this->assertDatabaseCount('depot_stock', 0);
    }
}
