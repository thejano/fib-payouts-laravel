<?php

namespace TheJano\FibPayouts\Providers;

use Illuminate\Support\ServiceProvider;
use TheJano\FibPayouts\FibPayout;

class FibPayoutsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/fib-payout.php' => config_path('fib-payout.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/fib-payout.php', 'fib-payout');

        $this->app->singleton(FibPayout::class, function ($app) {
            return FibPayout::make();
        });
    }
}