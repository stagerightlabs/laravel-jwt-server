<?php

namespace Tests;

use App\User;
use Laravel\Passport\Client;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create an access token for a fake user
     */
    public function authorization(Authenticatable $user)
    {
        $client = factory(Client::class)->state('password')->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        if ($response->status() != 200) {
            $this->fail("An access token could not be generated for {$user->email}");
        }

        $token = 'Bearer ' . $response->decodeResponseJson('access_token');

        return ['Authorization' => $token];
    }

    /**
     * A helper method to create an active token for a user and apply
     * it to the request headers.
     *
     * @param Authenticatable $user
     * @param string $driver
     * @return Authenticatable
     */
    public function actingAs(Authenticatable $user, $driver = null)
    {
        $this->withHeaders($this->authorization($user));

        return $user;
    }
}
