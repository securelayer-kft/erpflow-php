<?php
declare(strict_types=1);
namespace ERPFlow\Api;

use ERPFlow\Client;
use ERPFlow\Response;
use ERPFlow\BinaryResponse;

abstract class AbstractApi
{
    public function __construct(protected readonly Client $client) {}

    protected function data(string $method,string $path,array $query=[],mixed $body=null,array $headers=[]): mixed
    {
        /** @var Response $r */
        $r=$this->client->request($method,$path,$query,$body,$headers,false);
        return $r->data;
    }
    protected function response(string $method,string $path,array $query=[],mixed $body=null,array $headers=[]): Response
    {
        /** @var Response $r */
        $r=$this->client->request($method,$path,$query,$body,$headers,false);
        return $r;
    }
    protected function binary(string $path,array $query=[]): BinaryResponse
    {
        /** @var BinaryResponse $r */
        $r=$this->client->request('GET',$path,$query,null,[],true);
        return $r;
    }
}