<?php
declare(strict_types=1);
namespace ERPFlow\Api;

use ERPFlow\BinaryResponse;

final class DocumentsApi extends AbstractApi
{
    public function list(array $query=[]): array { return (array)$this->data('GET','/documents',$query); }
    public function get(int $id): array { return (array)$this->data('GET','/documents/'.$id); }
    public function getByVendorId(string $vendorId): array { return (array)$this->data('GET','/documents/vendor/'.rawurlencode($vendorId)); }

    public function create(array $body,?string $idempotencyKey=null): array
    {
        $h=$idempotencyKey!==null?['Idempotency-Key'=>$idempotencyKey]:[];
        return (array)$this->data('POST','/documents',[],$body,$h);
    }
    /** Converts an existing draft into an issued document. */
    public function convertDraft(int $id,array $body): array { return (array)$this->data('PUT','/documents/'.$id,[],$body); }
    public function deleteDraft(int $id): void { $this->response('DELETE','/documents/'.$id); }

    public function publicUrl(int $id): array { return (array)$this->data('GET','/documents/'.$id.'/public-url'); }
    public function send(int $id,array $body=[]): array { return (array)$this->data('POST','/documents/'.$id.'/send',[],$body); }
    public function onlineSzamla(int $id): array { return (array)$this->data('GET','/documents/'.$id.'/online-szamla'); }
    public function posPdf(int $id,int $size): BinaryResponse { return $this->binary('/documents/'.$id.'/print/pos',['size'=>$size]); }
    public function download(int $id): BinaryResponse { return $this->binary('/documents/'.$id.'/download'); }

    public function archive(int $id): void { $this->response('PUT','/documents/'.$id.'/archive'); }
    public function copy(int $id): array { return (array)$this->data('POST','/documents/'.$id.'/copy',[],[]); }
    public function createFromProforma(int $id,array $body=[]): array { return (array)$this->data('POST','/documents/'.$id.'/create-from-proforma',[],$body); }
    public function createModification(int $id,array $body): array { return (array)$this->data('POST','/documents/'.$id.'/create-modification-document',[],$body); }
    public function cancel(int $id,array $body=[]): array { return (array)$this->data('POST','/documents/'.$id.'/cancel',[],$body); }

    public function payments(int $id): array { return (array)$this->data('GET','/documents/'.$id.'/payments'); }
    public function replacePayments(int $id,array $payments): array { return (array)$this->data('PUT','/documents/'.$id.'/payments',[],$payments); }
    public function deletePayments(int $id): array { return (array)$this->data('DELETE','/documents/'.$id.'/payments'); }
}