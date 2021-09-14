<?php

namespace Sitic\Auth;

use Dusterio\LumenPassport\PassportServiceProvider;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\MailManager;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\ServiceProvider;
use Sitic\Auth\Console\Commands\sitic\InstallAuth;
use Sitic\Auth\Providers\EventServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    public function boot()
    {
        // Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Config Files
        $this->mergeConfigFrom(__DIR__.'/config/auth.php', 'auth');
        $this->mergeConfigFrom(__DIR__.'/config/passport.php', 'passport');
        $this->mergeConfigFrom(__DIR__.'/config/services.php', 'services');
        $this->mergeConfigFrom(__DIR__.'/config/sluggable.php', 'sluggable');
        $this->mergeConfigFrom(__DIR__.'/config/permission.php', 'permission');

        // Views
        $this->loadViewsFrom(__DIR__ . '/resources/views/auth', 'auth');

        // Translations
        $this->loadJsonTranslationsFrom(__DIR__.'/resources/lang');

        // Commands
        if ($this->app->runningInConsole()) {
            $this->commands(
                InstallAuth::class
            );
        }
    }

    public function register()
    {
        // Config Files
        $this->app->configure('auth');
        $this->app->configure('passport');
        $this->app->configure('services');
        $this->app->configure('sluggable');
        $this->app->configure('queue');

        // Providers
        $this->app->register(EventServiceProvider::class);
        $this->app->register(\App\Providers\AuthServiceProvider::class);
        $this->app->register(\Laravel\Passport\PassportServiceProvider::class);
        $this->app->register(PassportServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->configure('permission');
        $this->app->alias('cache', \Illuminate\Cache\CacheManager::class);

        // Mail
        $this->app->register(MailServiceProvider::class);

        $this->app->configure('mail');

        // Aliases
        $this->app->alias('mail.manager', MailManager::class);
        $this->app->alias('mail.manager', Factory::class);
        $this->app->alias('mailer', Mailer::class);
        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);
        $this->app->alias('mailer', MailQueue::class);
    }
}
