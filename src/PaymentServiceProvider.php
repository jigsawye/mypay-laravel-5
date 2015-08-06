<?php

namespace Jigsawye\Mypay;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/mypay.php';
        $this->mergeConfigFrom($configPath, 'mypay');

        $this->app->bind('guzzle.client', function () {
            return new Client();
        });

        $this->app->bind('mypay', function ($app) {
            return new Payment($app['config'], $app['request'], $app['guzzle.client']);
        });
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/mypay.php' => config_path('mypay.php')
        ], 'config');
    }
}
