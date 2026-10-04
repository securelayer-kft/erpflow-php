<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class ReceiptsApi extends AbstractApi
{
    public function create(array $body): array { return (array)$this->data('POST','/documents/receipt',[],$body); }
    public function convertDraft(int $id,array $body=[]): array { return (array)$this->data('PUT','/documents/receipt/'.$id,[],$body); }
}