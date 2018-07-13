<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function generateValidJsonWebToken(User $user)
    {
        return $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'secret',
        ])->decodeResponseJson()['access_token'];
    }
}
