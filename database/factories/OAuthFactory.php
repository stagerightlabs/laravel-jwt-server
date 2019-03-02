<?php

use Laravel\Passport\Client;

$factory->define(Client::class, function () {
    return [
        'user_id' => null,
        'name' => 'OAuth Client',
        'secret' => 'Dtg9myGAIsTUbTck2kxrxeZ5TDnE1qbVvTeYIuPN',
        'redirect' => 'http://localhost',
        'personal_access_client' => false,
        'password_client' => false,
        'revoked' => false
    ];
});

$factory->state(Client::class, 'password', [
    'name' => 'Password Client',
    'password_client' => true,
]);
