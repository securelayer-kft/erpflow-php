<?php
declare(strict_types=1);
namespace ERPFlow\Api;
use ERPFlow\BinaryResponse;
final class ExportsApi extends AbstractApi
{
    public function create(array $body): array { return (array)$this->data('POST','/document-export',[],$body); }
    public function poll(string $id): array { return (array)$this->data('GET','/document-export/'.rawurlencode($id).'/poll'); }
    public function download(string $id): BinaryResponse { return $this->binary('/document-export/'.rawurlencode($id).'/download'); }
}