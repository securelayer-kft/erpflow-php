<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class DocumentBlocksApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/document-blocks',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/document-blocks/'.$id); }
}