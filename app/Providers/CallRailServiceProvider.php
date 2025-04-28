<?php

namespace App\Providers;

use App\CallRailService\CallRail;
use Illuminate\Support\ServiceProvider;

class CallRailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('callrail', function () {
            return new CallRail();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
