<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A valid user can be registered.
     *
     * @return void
     */
    public function test_a_new_user_can_register()
    {
        factory(Client::class)->state('password')->create();
        $user = factory(User::class)->make();

        $response = $this->postJson('api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    /**
     * An invalid user is not registered.
     *
     * @return void
     */
    public function test_invalid_registration_requests_are_denied()
    {
        factory(Client::class)->state('password')->create();
        $user = factory(User::class)->make();

        $response = $this->postJson('api/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'invalid'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('password');
        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
