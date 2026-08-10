<?php

declare(strict_types=1);

namespace ChrisJohnLeah\BigChangeLaravel\Facades;

use ChrisJohnLeah\BigChangeLaravel\BigChangeManager;
use Illuminate\Support\Facades\Facade;

final class BigChange extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BigChangeManager::class;
    }
}
