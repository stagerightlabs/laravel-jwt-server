# JWT with Laravel and Vue.js

This repo is a proof of concept demo for using [Json Web Tokens](https://jwt.io/) to gain secure access to a Laravel PHP API.  In this project we are extending the native Laravel Auth tools to support JWT via the "[tymon/jwt-auth](https://packagist.org/packages/tymon/jwt-auth)" package.  See the companion repository for an example of a VueJs JWT client application.


## Installation

Start by cloning this project to your local dev machine.  After that, install the Laravel dependencies:

```bash
~/project/laravel$ composer install
~/project/laravel$ touch database/database.sqlite
~/project/laravel$ cp .env.example .env
~/project/laravel$ php artisan key:generate
```

The [tymon/jwt-auth](https://packagist.org/packages/tymon/jwt-auth) package uses its own "JWT_SECRET" env var as its encryption seed value.  Make sure you generate it by running:

```bash
~/project/laravel$ php artisan jwt:secret
```

Make sure to change the `.env` ``"DB_DATABASE"`` config value to be the absolute path of your newly created `database.sqlite` file, and the ``"FRONTEND_URL"`` value to be the url for your JWT client application.

It is important to note that running `composer install` will not automatically run the database migrations.  Once you have confirmed that the database configuration values in the `.env` file are correct run the migrations like so:

```bash
php artisan migrate
```

This will create an empty `users` table.

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

As you [can see here](https://github.com/SRLabs/laravel-vue-jwt/blob/master/laravel/app/Http/Middleware/VerifyCsrfToken.php#L15), we are explicitly disabling Laravel's built-in CSRF protection for the API endpoints.  To compensate for that, we use the [barryvdh/laravel-cors](https://packagist.org/packages/barryvdh/laravel-cors) package to set up a Cross Origin Resource Sharing whitelist.  In this case we use the "FRONTEND_URL" value from the `.env` settings as the whitelisted domain.
