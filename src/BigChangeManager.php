<?php

declare(strict_types=1);

namespace ChrisJohnLeah\BigChangeLaravel;

use ChrisJohnLeah\BigChange\BigChangeClient;
use ChrisJohnLeah\BigChange\BigChangeTokenConnector;
use ChrisJohnLeah\BigChange\Data\BigChangeCredentials;
use ChrisJohnLeah\BigChangeLaravel\Contracts\TokenStore;

final readonly class BigChangeManager
{
    public function __construct(private TokenStore $tokens) {}

    /**
     * @param  array<string, mixed>  $values
     */
    public function client(array $values, bool $forceRefresh = false): BigChangeClient
    {
        $credentials = BigChangeCredentials::fromArray($values);
        $key = hash('sha256', implode('|', [
            $credentials->clientId,
            $credentials->customerId,
            $credentials->apiBaseUrl,
            $credentials->tokenUrl,
            $credentials->scope ?? '',
        ]));
        $token = $forceRefresh ? null : $this->tokens->get($key);

        if ($token === null) {
            $authenticator = (new BigChangeTokenConnector($credentials))->getAccessToken();
            $token = $authenticator->getAccessToken();
            $expiresAt = $authenticator->getExpiresAt();
            $expiresIn = $expiresAt === null ? 3600 : max(60, $expiresAt->getTimestamp() - now()->timestamp - 60);
            $this->tokens->put($key, $token, $expiresIn);
        }

        return new BigChangeClient($credentials, $token);
    }
}
