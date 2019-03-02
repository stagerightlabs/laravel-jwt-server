# Laravel JWT Server

[![Build Status](https://travis-ci.org/SRLabs/laravel-jwt-server.svg?branch=master)](https://travis-ci.org/SRLabs/laravel-jwt-server)

This is a proof-of-concept demonstration of a Laravel API service with authentication provided by [Json Web Tokens](https://jwt.io/).  In this project we are extending the native Laravel Auth tools to support JWT via the [Laravel Passport](https://laravel.com/docs/master/passport) package.  See the [companion repository](https://github.com/SRLabs/vue-jwt-client) for an example of a VueJs JWT client application that uses this API service.

The current version of this project was built with these open source packages, among others:

- Laravel v5.8
- Laravel Passport v7.2
- [barryvdh/laravel-cors](https://packagist.org/packages/barryvdh/laravel-cors) v0.11.3

## Installation

Start by cloning this project to your local dev machine.  After that, install the Laravel dependencies:

```bash
~/project/laravel$ composer install
~/project/laravel$ touch database/database.sqlite
~/project/laravel$ cp .env.example .env
~/project/laravel$ php artisan key:generate
```

Make sure to change the `.env` `DB_DATABASE` config value to be the absolute path of your newly created `database.sqlite` file, and the ``"CORS_URL"`` value to be the url for your JWT client application.

It is important to note that running `composer install` will not automatically run the database migrations.  Once you have confirmed that the database configuration values in the `.env` file are correct run the migrations like so:

```bash
php artisan migrate
```

Next, we will configure Laravel Passport:

```bash
~/project/laravel$ php artisan passport:install
```

The passport installation command will generate a "Password Grant" client secret.  Save this as the `PASSPORT_CLIENT_SECRET` value in your `.env` file.

You should now be ready to go.

## Serving

The laravel application can be served using any of the recommended methods: [Valet](https://laravel.com/docs/5.5/valet), [Homestead](https://laravel.com/docs/5.5/homestead), [Docker](http://laradock.io/).  Be sure to update the values in your `.env` file appropriately.

You can also use the native php development server like so:

```bash
php artisan serve
```

## Tests

The PHP unit tests can be run like so:

```bash
vendor/bin/phpunit
```

## A note on CORS and CSRF Protection

As you [can see here](https://github.com/SRLabs/laravel-vue-jwt/blob/master/laravel/app/Http/Middleware/VerifyCsrfToken.php#L15), we are explicitly disabling Laravel's built-in CSRF protection for the API endpoints.  To compensate for that, we use the [barryvdh/laravel-cors](https://packagist.org/packages/barryvdh/laravel-cors) package to set up a Cross Origin Resource Sharing whitelist.  In this case we use the `CORS_URL` value from the `.env` settings as the white-listed domain.
