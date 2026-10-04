<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class BankAccountsApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/bank-accounts',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/bank-accounts/'.$id); }
    public function create(array $body): array { return (array)$this->data('POST','/bank-accounts',[],$body); }
    public function update(int $id,array $body): array { return (array)$this->data('PUT','/bank-accounts/'.$id,[],$body); }
    public function delete(int $id): void { $this->response('DELETE','/bank-accounts/'.$id); }
}