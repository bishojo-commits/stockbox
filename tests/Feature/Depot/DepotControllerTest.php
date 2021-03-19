<?php

namespace Tests\Feature\Depot;

use App\Traits\DateFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Depot;
use App\Models\Stock;
use Tests\TestCase;

class DepotControllerTest extends TestCase
{
    use DateFormatter;

    public function testIndexRouteMustBeAuthenticated()
    {
        $this->get('/depot')->assertRedirect('/login');
    }

    public function testDepotStockReturnedOnIndex()
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

        $this->actingAs($user)->get(route('depot.index'))
            ->assertJsonFragment(['id' => $user->id]);
    }

    public function testShowRouteMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->get(route('depot.show', $depot))
            ->assertRedirect('/login');
    }

    public function testShowRouteOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->get(route('depot.show', $depot))
            ->assertStatus(200);
    }

    public function testCreateRouteMustBeAuthenticated()
    {
        $this->get(route('depot.create'))
            ->assertRedirect('/login');
    }

    public function testCreateRouteOk()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('depot.create'))
            ->assertStatus(200);
    }

    public function testDestroyRouteMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->delete(route('depot.destroy', $depot))
            ->assertRedirect('/login');
    }

    public function testDestroyRouteOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->delete(route('depot.destroy', $depot));

        $this->assertDatabaseCount('depots', 0);
    }
}
