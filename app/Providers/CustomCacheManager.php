<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Predis\Connection\ConnectionException;

class CustomCacheManager extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        try {
            // Attempt to ping Redis
            Cache::store('redis')->get('test_connection');
        } catch (ConnectionException $e) {
            // If Redis is down, switch to file cache
            Config::set('cache.default', 'file');

            // Log the event
            Log::warning('Redis is down. Switched to file cache driver.');
        }
    }
}
