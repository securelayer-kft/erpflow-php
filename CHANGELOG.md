# Changelog

## 1.1.0 - 2026-10-04
- Full ERPFlow Public API v3 method+route coverage inventory (52/52).
- Added `ERPFlow\Contract` with API enums and endpoint manifest.
- Added route-semantic aliases for document/export operations while preserving v1.0 compatibility.
- Added full contract routing test with fake transport; no live API key required.
- Updated SDK User-Agent to ERPFlow-PHP/1.1.
- Documented current server-side contract limitations.


All notable changes to the ERPFlow PHP SDK are documented here.

## 1.0.0 - 2026-10-04

- Initial public ERPFlow Public API v3 PHP SDK release.
- Organization, document blocks, bank accounts, partners and products APIs.
- Documents, receipts, spendings and document export APIs.
- Utility endpoints including currency rate, tax-number check and legacy ID conversion.
- Binary document/export downloads.
- ERPFlow API exception handling and response metadata.
- `Idempotency-Key` support for document creation.
- Injectable `TransportInterface` for application testing.
- Composer PSR-4 autoloading.
