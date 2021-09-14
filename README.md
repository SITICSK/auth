# Auth

This package is for User Management. It allows to CRUD users, get OAuth Token, Change Email / Password.

### LUMEN Implementation

### 1. Install the package
```
composer require sitic/auth
```
### 2. Add in **bootstrap/app.php**

**Route Middlewares**
```php
/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role'       => Spatie\Permission\Middlewares\RoleMiddleware::class,
]);

```

**Providers**
```php
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
$app->register(\Sitic\Auth\AuthServiceProvider::class);
```

**Application Routes**
```php
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/
\Dusterio\LumenPassport\LumenPassport::routes($app, ['prefix' => 'api/v1/oauth']);
```

### 4. Install Auth
```
php artisan sitic:auth
```

### 5. Run migrations
```
php artisan migrate
```

### 7. Install passport and place output in .env file
```
php artisan passport:install

output to .env file

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

PASSPORT_LOGIN_ENDPOINT=/api/v1/oauth/token
PASSPORT_CLIENT_ID=<client_id>
PASSPORT_CLIENT_SECRET=<client_secret>
```
