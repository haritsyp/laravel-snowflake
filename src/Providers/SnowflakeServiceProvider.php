<?php

namespace Haritsyp\Snowflake\Providers;

use Haritsyp\Snowflake\Snowflake;
use Illuminate\Support\ServiceProvider;

class SnowflakeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(Snowflake::class, function ($app) {
            $datacenter = config('snowflake.datacenter', 1);
            $node = config('snowflake.node', 1);
            $format = config('snowflake.format', 'int');
            return new Snowflake($datacenter, $node, $format);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
