<?php

namespace MohamedReda\Toaster;

use Illuminate\Support\ServiceProvider;

class ToasterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/toaster.php' => config_path('toaster.php'),
        ], 'config');
    }

    /**
     * Get the services provider by the provider
     *
     * @return array
     */
    public function provides()
    {
        return ['toaster'];
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('toaster', function ($app) {
            return new Toaster($app['session'], $app['config']);
        });
    }
}
