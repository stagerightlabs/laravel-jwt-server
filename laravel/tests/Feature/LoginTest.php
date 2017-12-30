<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A valid user can be logged in.
     *
     * @return void
     */
    public function testLoginAValidUser()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        $this->assertAuthenticatedAs($user, 'api');
    }

    /**
     * An invalid user cannot be logged in.
     *
     * @return void
     */
    public function testDoesNotLoginAnInvalidUser()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertGuest('api');
    }

    /**
     * A logged in user can be logged out.
     *
     * @return void
     */
    public function testLogoutAnAuthenticatedUser()
    {
        $this->withoutExceptionHandling();


        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->postJson('api/logout');

        $response->assertStatus(204);
        $this->assertGuest('api');
    }
}
