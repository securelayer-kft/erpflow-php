<?php
declare(strict_types=1);

namespace ERPFlow;

use ERPFlow\Api\BankAccountsApi;
use ERPFlow\Api\DocumentBlocksApi;
use ERPFlow\Api\DocumentsApi;
use ERPFlow\Api\ExportsApi;
use ERPFlow\Api\OrganizationApi;
use ERPFlow\Api\PartnersApi;
use ERPFlow\Api\ProductsApi;
use ERPFlow\Api\ReceiptsApi;
use ERPFlow\Api\SpendingsApi;
use ERPFlow\Api\UtilsApi;
use ERPFlow\Http\CurlTransport;
use ERPFlow\Http\TransportInterface;

final class Client
{
    private TransportInterface $transport;

    public function __construct(
        private readonly string $apiKey,
        private readonly string $baseUrl = 'https://api.erpflow.hu/v3',
        int $timeout = 30,
        ?TransportInterface $transport = null
    ) {
        if (trim($apiKey) === '') {
            throw new \InvalidArgumentException('ERPFlow API key is required.');
        }

        $this->transport = $transport ?? new CurlTransport($timeout);
    }

    public function request(
        string $method,
        string $path,
        array $query = [],
        mixed $body = null,
        array $headers = [],
        bool $binary = false
    ): Response|BinaryResponse {
        $url = rtrim($this->baseUrl, '/').'/'.ltrim($path, '/');

        if ($query !== []) {
            $url .= '?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        }

        $headers = [
            'X-API-KEY' => $this->apiKey,
            'Accept' => $binary
                ? 'application/pdf, text/csv, application/octet-stream'
                : 'application/json',
            'User-Agent' => 'ERPFlow-PHP/1.1',
        ] + $headers;

        if ($body !== null) {
            $headers['Content-Type'] = 'application/json';
        }

        return $this->transport->send($method, $url, $headers, $body, $binary);
    }

    public function organization(): OrganizationApi { return new OrganizationApi($this); }
    public function documentBlocks(): DocumentBlocksApi { return new DocumentBlocksApi($this); }
    public function bankAccounts(): BankAccountsApi { return new BankAccountsApi($this); }
    public function partners(): PartnersApi { return new PartnersApi($this); }
    public function products(): ProductsApi { return new ProductsApi($this); }
    public function documents(): DocumentsApi { return new DocumentsApi($this); }
    public function receipts(): ReceiptsApi { return new ReceiptsApi($this); }
    public function spendings(): SpendingsApi { return new SpendingsApi($this); }
    public function exports(): ExportsApi { return new ExportsApi($this); }
    public function utils(): UtilsApi { return new UtilsApi($this); }
}
