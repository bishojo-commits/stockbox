<?php

namespace Tests\Feature\Depot;

use App\Models\Depot;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotControllerUpdateTest extends TestCase
{
    use WithFaker;

    public function testUpdateRouteMustBeAuthenticated()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->patch(route('depot.update', $depot))
            ->assertRedirect('/login');
    }

    public function testUpdateDataRequiresDepotTitle()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->patch(route('depot.update', $depot), [])
            ->assertSessionHasErrors(['depot_title']);
    }

    public function testUpdateDataRequiresDepotTitleMin3Chars()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->patch(route('depot.update', $depot),
                ['depot_title' => ''])
            ->assertSessionHasErrors(['depot_title']);
    }

    public function testUpdateDataRequiresDepotCurrency()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->patch(route('depot.update', $depot), [])
            ->assertSessionHasErrors('depot_currency');
    }

    public function testUpdateDataOk()
    {
        $user = factory(User::class)->create();
        $depot = factory(Depot::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->patch(route('depot.update', $depot), [
                'depot_title' => $title = 'fiveLetters',
                'depot_currency' => $this->faker->currencyCode
            ]);

        $this->assertDatabaseHas('depots', ['depot_title' => $title]);
    }
}
