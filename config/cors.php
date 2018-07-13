<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => false,
    'allowedOrigins' => [getenv('FRONTEND_URL')],
    'allowedHeaders' => ['Authorization', 'Content-Type', 'X-Requested-With'],
    'allowedMethods' => ['GET','POST','PUT', 'OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
