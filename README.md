# BigChange API — Laravel

Laravel bridge for [`chrisjohnleah/bigchange-api`](https://github.com/chrisjohnleah/bigchange-api), the
framework-agnostic Saloon SDK for the BigChange REST API and optional JobWatch
attachment service.

```shell
composer require chrisjohnleah/bigchange-api-laravel
```

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
$assets = $client->assetManagementClient()->assets(pageSize: 2000);

$jobWatch = BigChange::jobWatchClient([
    'jobwatch_username' => $username,
    'jobwatch_password' => $password,
    'jobwatch_company_key' => $companyKey,
]);
```

JobWatch uses separate Basic Auth credentials and a company-key header. Only
use it when the customer's BigChange account has the JobWatch service enabled.

Publish the optional cache configuration with:

```shell
php artisan vendor:publish --tag=bigchange-config
```

The cache store only holds short-lived access tokens. Credentials should be
provided by the consuming application’s secret manager or environment.
