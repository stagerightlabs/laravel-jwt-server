<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Token;
use Laravel\Passport\Client;
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
    public function test_tokens_can_be_issued_to_valid_users()
    {
        factory(Client::class)->state('password')->create();
        $user = factory(User::class)->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token'
        ]);
        $this->assertEquals(1, Token::where('user_id', $user->id)->count());
    }

    /**
     * An invalid user cannot be logged in.
     *
     * @return void
     */
    public function test_invalid_users_cannot_be_issued_tokens()
    {
        factory(Client::class)->state('password')->create();
        $user = factory(User::class)->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);

        $response->assertJsonValidationErrors('email');
        $this->assertEquals(0, Token::count());
    }

    /**
     * A logged in user can be logged out.
     *
     * @return void
     */
    public function test_tokens_can_be_revoked()
    {
        $user = $this->actingAs(factory(User::class)->create());
        $this->assertEquals(1, Token::where('user_id', $user->id)->where('revoked', false)->count());
        $this->assertEquals(0, Token::where('user_id', $user->id)->where('revoked', true)->count());

        $response = $this->postJson(route('logout'));

        $response->assertStatus(204);
        $this->assertEquals(0, Token::where('user_id', $user->id)->where('revoked', false)->count());
        $this->assertEquals(1, Token::where('user_id', $user->id)->where('revoked', true)->count());
    }
}
