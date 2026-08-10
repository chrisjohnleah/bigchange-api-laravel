<?php

declare(strict_types=1);

namespace ChrisJohnLeah\BigChangeLaravel;

use ChrisJohnLeah\BigChangeLaravel\Contracts\TokenStore;
use Illuminate\Contracts\Cache\Repository;

final readonly class CacheTokenStore implements TokenStore
{
    public function __construct(
        private Repository $cache,
        private string $prefix = 'bigchange',
    ) {}

    public function get(string $key): ?string
    {
        $token = $this->cache->get($this->key($key));

        return is_string($token) && $token !== '' ? $token : null;
    }

    public function put(string $key, string $token, int $expiresIn): void
    {
        $this->cache->put($this->key($key), $token, max(60, $expiresIn));
    }

    private function key(string $key): string
    {
        return $this->prefix.':token:'.$key;
    }
}
