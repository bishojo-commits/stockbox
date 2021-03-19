<?php

namespace Tests\Feature\Depot;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotControllerStoreTest extends TestCase
{
    use WithFaker;

    public function testStoreRouteMustBeAuthenticated()
    {
        $this->post(route('depot.store'))
            ->assertRedirect('/login');
    }

    public function testStoreDataRequiresDepotTitle()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('depot.store'), ['depot_title' => ''])
            ->assertSessionHasErrors('depot_title');
    }

    public function testStoreDataRequiresDepotTitleMin3Chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('depot.store'), ['depot_title' => 'no'])
            ->assertSessionHasErrors('depot_title');
    }

    public function testStoreDataRequiresDepotCurrency()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('depot.store'), ['depot_currency' => ''])
            ->assertSessionHasErrors('depot_currency');
    }

    public function testStoreDataOk()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('depot.store'), [
                'depot_title' => 'fiveLetters',
                'depot_currency' => $this->faker->currencyCode
            ]);

        $this->assertDatabaseCount('depots', 1);
    }
}
