<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class ProductsApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/products',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/products/'.$id); }
    public function create(array $body): array { return (array)$this->data('POST','/products',[],$body); }
    public function update(int $id,array $body): array { return (array)$this->data('PUT','/products/'.$id,[],$body); }
    public function delete(int $id): void { $this->response('DELETE','/products/'.$id); }
}