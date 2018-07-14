<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Instantiate our simulated Laravel Application
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        // Set a JWT secret
        config(['jwt.secret' => 'KuOKxHrUD2wJMGK1PL0X4lShInx2O0g3']);

        return $app;
    }
}
