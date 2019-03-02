<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMacros();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register application macros
     *
     * @return void
     */
    protected function registerMacros()
    {
        // Transform a password token into a Json Response
        Response::macro('authorization', function ($request) {
            $client = Client::where('password_client', true)
                ->where('secret', config('jwt.client_secret'))
                ->where('revoked', false)
                ->first();

            if (!$client) {
                return response()->json(['message' => 'Token Service Unavailable'], 503);
            }

            return app()->handle(
                Request::create('/oauth/token', 'POST', [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => '*'
                ])
            );
        });
    }
}
