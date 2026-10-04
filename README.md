# ERPFlow PHP SDK

Official PHP SDK for the **ERPFlow Public API v3**.

## Requirements

- PHP 8.1+
- cURL extension
- JSON extension
- ERPFlow API token with the required `api:read` / `api:write` scopes

## Installation

Recommended installation through Composer:

```bash
composer require erpflow/erpflow-php
```

Until the first Packagist release is published, the source repository can be used directly for development.

## Quick start

```php
<?php

require __DIR__.'/vendor/autoload.php';

use ERPFlow\Client;

$erpflow = new Client($_ENV['ERPFLOW_API_KEY']);

$organization = $erpflow->organization()->get();
```

Never expose an ERPFlow API key to browser-side JavaScript or commit it to source control.

## API groups

```php
$erpflow->organization();
$erpflow->documentBlocks();
$erpflow->bankAccounts();
$erpflow->partners();
$erpflow->products();
$erpflow->documents();
$erpflow->receipts();
$erpflow->spendings();
$erpflow->exports();
$erpflow->utils();
```

## Create a partner

```php
$partner = $erpflow->partners()->create([
    'name' => 'Minta Kft.',
    'taxcode' => '12345678-2-42',
    'emails' => ['invoice@example.hu'],
    'address' => [
        'country_code' => 'HU',
        'post_code' => '1051',
        'city' => 'Budapest',
        'address' => 'Minta utca 1.',
    ],
]);
```

## Create an invoice

For document creation, use a stable `vendor_id` and `Idempotency-Key`.

```php
$invoice = $erpflow->documents()->create([
    'vendor_id' => 'order-10001',
    'partner_id' => $partner['id'],
    'block_id' => 1,
    'type' => 'invoice',
    'fulfillment_date' => '2026-10-04',
    'due_date' => '2026-10-12',
    'payment_method' => 'wire_transfer',
    'language' => 'hu',
    'currency' => 'HUF',
    'electronic' => true,
    'items' => [[
        'name' => 'Szolgáltatás',
        'unit_price' => 10000,
        'unit_price_type' => 'net',
        'quantity' => 1,
        'unit' => 'db',
        'vat' => '27%',
    ]],
], 'order-10001');
```

## Error handling

```php
use ERPFlow\Exception\ApiException;

try {
    $document = $erpflow->documents()->get(123);
} catch (ApiException $e) {
    echo $e->getMessage();
    echo $e->statusCode();
}
```

## Binary downloads

```php
$pdf = $erpflow->documents()->download(123);

file_put_contents('invoice.pdf', $pdf->body());
```

## Custom transport / testing

`Client` accepts an optional `TransportInterface`, making the SDK mockable without making real API requests:

```php
$erpflow = new Client(
    'api-key',
    'https://api.erpflow.hu/v3',
    30,
    $customTransport
);
```

## API compatibility notes

The SDK follows the ERPFlow Public API v3 contract. Some API responses intentionally preserve existing API field names for backwards compatibility, including `conversation_rate` in the currency-rate response.

The SDK does not blindly retry document-creation requests. Applications should use stable idempotency keys and implement retry policy at the application/job layer.

## Source and releases

Source repository: `securelayer-kft/erpflow-php` on GitHub.

Stable Composer releases are published from Git tags such as `v1.0.0`. The package itself intentionally does not contain a hard-coded Composer `version` field.

## License

MIT. Copyright © 2026 SecureLayer Kft.


## API v3 full contract coverage (v1.1.0)

Version 1.1.0 exposes all 52 method+route combinations found in the audited ERPFlow Public API v3 router. `ERPFlow\Contract::ENDPOINTS` contains the canonical inventory and `ERPFlow\Contract` also exposes the contract enums used by integrations.

Coverage includes organization, currency conversion, tax-number and legacy-ID utilities, both server-time routes, document blocks, bank accounts, partners, products, the complete document lifecycle, payments, receipts, spendings and document exports.

### Current server-side contract limitations

The SDK intentionally mirrors the server contract rather than pretending unsupported behavior exists:

- `simple_csv` is currently the executable document-export format even though the API contract recognizes additional export identifiers.
- `without_financial_fulfillment=true` for modification documents is currently rejected by the server.
- proforma conversion currently creates an invoice.
- the currency response preserves the existing `conversation_rate` field spelling for backwards compatibility.

The SDK performs transport and ergonomic wrapping; authoritative business validation remains server-side so new compatible server fields can be passed without waiting for an SDK release.
