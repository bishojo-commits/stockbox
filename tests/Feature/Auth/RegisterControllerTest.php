<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    public function testFirstnameFieldIsRequired()
    {
        $this->json('POST', '/register', [])
            ->assertJsonValidationErrors(['firstname']);
    }

    public function testFirstnameFieldDatatypeString()
    {
        $this->json('POST', '/register', ['name' => 123])
            ->assertJsonValidationErrors(['firstname']);
    }

    public function testLastnameFieldIsRequired()
    {
        $this->json('POST', '/register', [])
            ->assertJsonValidationErrors(['lastname']);
    }

    public function testLastnameFieldDatatypeString()
    {
        $this->json('POST', '/register', ['name' => 123])
            ->assertJsonValidationErrors(['lastname']);
    }

    public function testEmailFieldIsRequired()
    {
        $this->json('POST', '/register', [])
            ->assertJsonValidationErrors(['email']);
    }

    public function testEmailFieldValidEmail()
    {
        $this->json('POST', '/register', ['email' => 'notvalid'])
            ->assertJsonValidationErrors(['email']);
    }

    public function testEmailMustBeUnique()
    {
        $user = factory(User::class)->create([
            'email' => 'test@mail.com'
        ]);

        $this->json('POST', '/register', ['email' => $user->email])
            ->assertJsonValidationErrors(['email']);
    }

    public function testPasswordFieldIsRequired()
    {
        $this->json('POST', '/register', [])
            ->assertJsonValidationErrors(['password']);
    }

    public function testPasswordFieldRequiresMin8Chars()
    {
        $this->json('POST', '/register', ['password' => 'only5'])
            ->assertJsonValidationErrors(['password']);
    }

    public function testPasswordMustBeConfirmed()
    {
        $response = $this->json('POST', '/register', [
            'password' => 'password123', 'password_confirmation' => ''
        ]);

        $response->assertJsonValidationErrors(['password']);
    }

    public function testPasswordIsHashed()
    {
        $this->json('POST', '/register', [
                'firstname' => 'Hannah',
                'lastname' => 'McTest',
                'email' => $email = 'hannah@test',
                'password' => $password = 'testPwHannah',
                'password_confirmation' => 'testPwHannah'
            ]);

        $user = User::where('email', $email)->first();

        $this->assertTrue(Hash::check($password, $user->password));
    }
}
