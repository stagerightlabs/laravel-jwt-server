<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_view_protected_content()
    {
        $response = $this->getJson('api/secrets');

        $response->assertStatus(401);
        $response->assertJsonFragment(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function valid_tokens_can_view_protected_content()
    {
        $user = factory(User::class)->create();
        $token = $this->generateValidJsonWebToken($user);

        $response = $this->getJson('api/secrets', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'codewords' => [
                'kappa',
                'epsilon',
                'omicron',
                'omega'
            ]
        ]);
    }
}
