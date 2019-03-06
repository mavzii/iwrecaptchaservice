<?php

namespace IwPackages\RecaptchaService\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('InvisibleRecaptcha', \IwPackages\RecaptchaService\Support\Facades\InvisibleRecaptcha::class);
            $loader->alias('Recaptcha', \IwPackages\RecaptchaService\Support\Facades\Recaptcha::class);
        });
    }

    /**
     * Boot config file
     *
     * @return void
     */
    protected function bootConfig()
    {
        $config_file = __DIR__ . '/../config/checkpoints.php';

        $this->mergeConfigFrom($config_file, 'checkpoints');

        if (function_exists('config_path')) {
            $this->publishes([$config_file => config_path('checkpoints.php')]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->bootConfig();

        $router->aliasMiddleware('recaptcha', \IwPackages\RecaptchaService\Http\Middleware\Recaptcha::class);
        $router->aliasMiddleware('recaptcha.invisible', \IwPackages\RecaptchaService\Http\Middleware\InvisibleRecaptcha::class);
    }
}
