<?php
declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use ERPFlow\BinaryResponse;
use ERPFlow\Client;
use ERPFlow\Http\TransportInterface;
use ERPFlow\Response;

final class FakeTransport implements TransportInterface
{
    public array $last = [];

    public function send(
        string $method,
        string $url,
        array $headers = [],
        mixed $body = null,
        bool $binary = false
    ): Response|BinaryResponse {
        $this->last = compact('method', 'url', 'headers', 'body', 'binary');
        return new Response(200, ['ok' => true], ['x-request-id' => 'test'], '{"ok":true}');
    }
}

$transport = new FakeTransport();
$client = new Client('test-key', 'https://api.erpflow.hu/v3', 30, $transport);

$data = $client->partners()->list(['page' => 2, 'per_page' => 10]);
assert($data === ['ok' => true]);
assert($transport->last['method'] === 'GET');
assert(str_contains($transport->last['url'], '/partners?'));
assert(str_contains($transport->last['url'], 'page=2'));
assert(($transport->last['headers']['X-API-KEY'] ?? null) === 'test-key');

echo "ERPFlow PHP SDK smoke test: PASS\n";
