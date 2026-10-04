<?php
declare(strict_types=1);

namespace ERPFlow\Http;

use ERPFlow\BinaryResponse;
use ERPFlow\Response;

interface TransportInterface
{
    public function send(
        string $method,
        string $url,
        array $headers = [],
        mixed $body = null,
        bool $binary = false
    ): Response|BinaryResponse;
}
