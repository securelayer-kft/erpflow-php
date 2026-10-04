<?php
declare(strict_types=1);
namespace ERPFlow\Exception;

use RuntimeException;

final class ApiException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly int $statusCode = 0,
        private readonly mixed $response = null,
        private readonly array $responseHeaders = []
    ) { parent::__construct($message, $statusCode); }

    public function statusCode(): int { return $this->statusCode; }
    public function response(): mixed { return $this->response; }
    public function responseHeaders(): array { return $this->responseHeaders; }
}