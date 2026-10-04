<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class PartnersApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/partners',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/partners/'.$id); }
    public function create(array $body): array { return (array)$this->data('POST','/partners',[],$body); }
    public function update(int $id,array $body): array { return (array)$this->data('PUT','/partners/'.$id,[],$body); }
    public function delete(int $id): void { $this->response('DELETE','/partners/'.$id); }
}