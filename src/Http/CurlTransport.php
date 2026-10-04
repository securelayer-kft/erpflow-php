<?php
declare(strict_types=1);
namespace ERPFlow\Http;

use ERPFlow\Exception\ApiException;
use ERPFlow\Response;
use ERPFlow\BinaryResponse;

final class CurlTransport implements TransportInterface
{
    public function __construct(private readonly int $timeout = 30) {}

    public function send(string $method, string $url, array $headers = [], mixed $body = null, bool $binary = false): Response|BinaryResponse
    {
        $ch = curl_init($url);
        if ($ch === false) throw new ApiException('Unable to initialize cURL');

        $responseHeaders = [];
        $headerLines = [];
        foreach ($headers as $name => $value) $headerLines[] = $name.': '.$value;

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => min(10, $this->timeout),
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headerLines,
            CURLOPT_HEADERFUNCTION => static function ($ch, string $line) use (&$responseHeaders): int {
                $len = strlen($line);
                $line = trim($line);
                if ($line === '' || !str_contains($line, ':')) return $len;
                [$name,$value] = array_map('trim', explode(':',$line,2));
                $key = strtolower($name);
                if (isset($responseHeaders[$key])) {
                    $responseHeaders[$key] = (array)$responseHeaders[$key];
                    $responseHeaders[$key][] = $value;
                } else $responseHeaders[$key] = $value;
                return $len;
            },
        ]);

        if ($body !== null) {
            $json = json_encode($body, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        }

        $raw = curl_exec($ch);
        if ($raw === false) {
            $message = curl_error($ch);
            curl_close($ch);
            throw new ApiException('Transport error: '.$message);
        }
        $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($binary && $status >= 200 && $status < 300) return new BinaryResponse($status,(string)$raw,$responseHeaders);

        $decoded = null;
        if ((string)$raw !== '') {
            try { $decoded = json_decode((string)$raw,true,512,JSON_THROW_ON_ERROR); }
            catch (\JsonException) { $decoded = (string)$raw; }
        }

        if ($status < 200 || $status >= 300) {
            $message = is_array($decoded) && isset($decoded['message']) ? (string)$decoded['message'] : 'ERPFlow API HTTP '.$status;
            throw new ApiException($message,$status,$decoded,$responseHeaders);
        }

        return new Response($status,$decoded,$responseHeaders,(string)$raw);
    }
}