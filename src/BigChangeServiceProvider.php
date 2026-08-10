<?php

declare(strict_types=1);

namespace ChrisJohnLeah\BigChangeLaravel;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\ServiceProvider;

final class BigChangeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bigchange.php', 'bigchange');

        $this->app->singleton(CacheTokenStore::class, fn ($app): CacheTokenStore => new CacheTokenStore(
            $app->make(Repository::class),
            (string) config('bigchange.cache_prefix', 'bigchange'),
        ));

        $this->app->singleton(BigChangeManager::class, fn ($app): BigChangeManager => new BigChangeManager(
            $app->make(CacheTokenStore::class),
        ));

        $this->app->alias(BigChangeManager::class, 'bigchange');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/bigchange.php' => config_path('bigchange.php'),
        ], 'bigchange-config');
    }
}
