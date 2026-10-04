<?php
declare(strict_types=1);
require __DIR__.'/../vendor/autoload.php';

use ERPFlow\BinaryResponse;
use ERPFlow\Client;
use ERPFlow\Contract;
use ERPFlow\Http\TransportInterface;
use ERPFlow\Response;

final class RecordingTransport implements TransportInterface {
    public array $calls=[];
    public function send(string $method,string $url,array $headers=[],mixed $body=null,bool $binary=false): Response|BinaryResponse {
        $this->calls[]=[strtoupper($method),preg_replace('#^/v3#','',parse_url($url,PHP_URL_PATH)),parse_url($url,PHP_URL_QUERY),$body,$headers,$binary];
        return $binary ? new BinaryResponse(200,'binary',['content-type'=>'application/octet-stream']) : new Response(200,[],[],'[]');
    }
}
$t=new RecordingTransport(); $c=new Client('test-key',Contract::BASE_URL,30,$t);
$c->organization()->get();
$c->utils()->currencyRate('HUF','EUR'); $c->utils()->checkTaxNumber('12345678-2-42'); $c->utils()->convertLegacyId(1); $c->utils()->time(); $c->utils()->serverTime();
$c->documentBlocks()->list(); $c->documentBlocks()->get(1);
$c->bankAccounts()->list(); $c->bankAccounts()->create([]); $c->bankAccounts()->get(1); $c->bankAccounts()->update(1,[]); $c->bankAccounts()->delete(1);
$c->partners()->list(); $c->partners()->create([]); $c->partners()->get(1); $c->partners()->update(1,[]); $c->partners()->delete(1);
$c->products()->list(); $c->products()->create([]); $c->products()->get(1); $c->products()->update(1,[]); $c->products()->delete(1);
$c->documents()->list(); $c->documents()->create([], 'idem'); $c->documents()->get(1); $c->documents()->update(1,[]); $c->documents()->delete(1); $c->documents()->getByVendorId('vendor'); $c->documents()->download(1); $c->documents()->posPdf(1,80); $c->documents()->publicUrl(1); $c->documents()->send(1); $c->documents()->onlineSzamla(1); $c->documents()->archive(1); $c->documents()->copy(1); $c->documents()->createFromProforma(1); $c->documents()->createModificationDocument(1,[]); $c->documents()->cancel(1); $c->documents()->payments(1); $c->documents()->replacePayments(1,[]); $c->documents()->deletePayments(1);
$c->receipts()->create([]); $c->receipts()->convertDraft(1);
$c->spendings()->list(); $c->spendings()->create([]); $c->spendings()->get(1); $c->spendings()->update(1,[]); $c->spendings()->delete(1);
$c->exports()->createExport([]); $c->exports()->poll('uuid'); $c->exports()->download('uuid');

$actual=array_map(fn($x)=>[$x[0],preg_replace(['#/utils/check-tax-number/[^/]+$#','#/utils/convert-legacy-id/\d+$#','#/vendor/[^/]+#','#/document-export/[^/]+/#','#/\d+(?=/|$)#'],['/utils/check-tax-number/{tax_number}','/utils/convert-legacy-id/{id}','/vendor/{vendor_id}','/document-export/{id}/','/{id}'],$x[1])],$t->calls);
// receipt route must keep its specific template instead of generic id replacement
foreach($actual as &$e) if($e[1]==='/documents/receipt/{id}'){} unset($e);
$expected=Contract::ENDPOINTS;
if(count($actual)!==52 || count($expected)!==52){fwrite(STDERR,'FAIL count actual='.count($actual).' expected='.count($expected).PHP_EOL);exit(1);}
foreach($expected as $i=>$want){ if($actual[$i]!==$want){fwrite(STDERR,'FAIL #'.($i+1).' expected '.json_encode($want).' got '.json_encode($actual[$i]).PHP_EOL);exit(1);} }
// Verify idempotency header on document creation.
$docCreate=$t->calls[24]; if(($docCreate[4]['Idempotency-Key']??null)!=='idem'){fwrite(STDERR,"FAIL idempotency header\n");exit(1);}
echo "PASS ERPFlow API v3 contract coverage: 52/52 routes\n";
