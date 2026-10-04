<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class SpendingsApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/spendings',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/spendings/'.$id); }
    public function create(array $body): array { return (array)$this->data('POST','/spendings',[],$body); }
    public function update(int $id,array $body): array { return (array)$this->data('PUT','/spendings/'.$id,[],$body); }
    public function delete(int $id): void { $this->response('DELETE','/spendings/'.$id); }
}