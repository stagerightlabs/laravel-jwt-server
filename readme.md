# JWT with Laravel and Vue.js




## Installation

### Laravel


```bash
~/project/laravel$ composer install
~/project/laravel$ touch database/database.sqlite
~/project/laravel$ cp .env.example .env
~/project/laravel$ php artisan key:generate
```

Make sure to update your `.env` ``"DB_DATABASE"`` value to be the absolute path to your newly created `database.sqlite` file, and the ``"FRONTEND_URL"`` value to the url for your vue js application instance.


### Vue.js

```bash
~/project/vue$ npm install
```


## Serving

### Laravel

The laravel application can be served using any of the reccomended methods: [Valet](https://laravel.com/docs/5.5/valet), [Homestead](https://laravel.com/docs/5.5/homestead), [Docker](http://laradock.io/).  Be sure to update the values in your `.env` file appropriately.

You can also use the native php development server like so:

```bash
~/project/laravel$ php artisan serve
```

### Vue.js

These instructions have been borrowed from the [Vue CLI Webpack Template](https://github.com/vuejs-templates/webpack) Repo:

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run e2e tests
npm run e2e

# run all tests
npm test
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).