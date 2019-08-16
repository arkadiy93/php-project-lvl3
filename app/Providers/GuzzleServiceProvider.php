<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class GuzzleServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Client', function () {
            return new Client();
        });
    }
}
