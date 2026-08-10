<?php

use ChrisJohnLeah\BigChangeLaravel\CacheTokenStore;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

it('keeps short-lived BigChange tokens under the configured namespace', function () {
    $store = new CacheTokenStore(new Repository(new ArrayStore), 'tenant-bigchange');

    $store->put('connection-hash', 'token-value', 300);

    expect($store->get('connection-hash'))->toBe('token-value')
        ->and($store->get('other-connection'))->toBeNull();
});
