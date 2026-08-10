# BigChange API — Laravel

Laravel bridge for [`chrisjohnleah/bigchange-api`](../bigchange-api), the
framework-agnostic Saloon SDK for the BigChange REST API.

The bridge provides the `BigChange` facade, automatic service-provider
discovery, a cache-backed token store, and a manager that builds a
customer-scoped SDK client. OAuth transport, pagination, response types, and
provider limits remain in the core package; migration and plan policy belong
in the consuming application.

```php
use ChrisJohnLeah\BigChangeLaravel\Facades\BigChange;

$client = BigChange::client([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'customer_id' => $customerId,
]);

$jobs = $client->jobs(pageSize: 1000);
```

Publish the optional cache configuration with:

```shell
php artisan vendor:publish --tag=bigchange-config
```

The cache store only holds short-lived access tokens. Credentials should be
provided by the consuming application’s secret manager or environment.
