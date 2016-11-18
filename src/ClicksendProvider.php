<?php

namespace ClickSendNotification;

use ClickSendLib\Configuration;
use ClickSendLib\Controllers\SMSController;
use Illuminate\Support\ServiceProvider;

class ClicksendProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ClicksendChannel::class)
            ->needs(Clicksend::class)
            ->give(function () {

                $config = $this->app['config']['services.clicksend'];

                Configuration::$BASEURI = $config['base_uri'];
                Configuration::$username = $config['username'];
                Configuration::$key = $config['api_key'];

                return new Clicksend($this->app->make(SMSController::class));
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
