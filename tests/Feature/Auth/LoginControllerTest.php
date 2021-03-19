<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use WithFaker;

    public function testUserCanSeeLoginForm()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
    }

    public function testUserCantSeeloginFormWhenAuthenticated()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/dashboard');
    }

    public function testEmailIsRequired()
    {
        $this->json('POST', '/login', [])
            ->assertJsonValidationErrors(['email']);
    }

    public function testPasswordIsRequired()
    {
        $this->json('POST', '/login', [])
            ->assertJsonValidationErrors(['password']);
    }

    public function testLoginOk()
    {
        $user = factory(User::class)->create();

        Auth::login($user);

        $this->assertTrue(Auth::check());
    }
}
