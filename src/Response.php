<?php
declare(strict_types=1);
namespace ERPFlow;

final class Response
{
    public function __construct(
        public readonly int $status,
        public readonly mixed $data,
        public readonly array $headers = [],
        public readonly string $rawBody = ''
    ) {}

    public function requestId(): ?string
    {
        foreach ($this->headers as $k => $v) {
            if (strtolower((string)$k) === 'x-request-id') return is_array($v) ? (string)end($v) : (string)$v;
        }
        return null;
    }
}