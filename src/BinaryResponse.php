<?php
declare(strict_types=1);
namespace ERPFlow;

final class BinaryResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $body,
        public readonly array $headers = []
    ) {}

    public function saveTo(string $path): void
    {
        if (file_put_contents($path, $this->body) === false) {
            throw new \RuntimeException('Unable to write binary response to '.$path);
        }
    }
}