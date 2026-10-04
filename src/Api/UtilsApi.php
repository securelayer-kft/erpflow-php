<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class UtilsApi extends AbstractApi
{
    public function checkTaxNumber(string $taxNumber): array { return (array)$this->data('GET','/utils/check-tax-number/'.rawurlencode($taxNumber)); }
    public function convertLegacyId(int $legacyId): array { return (array)$this->data('GET','/utils/convert-legacy-id/'.$legacyId); }
    public function time(): array { return (array)$this->data('GET','/utils/time'); }
    public function serverTime(): array { return (array)$this->data('GET','/server-time'); }
    public function currencyRate(string $from,string $to,?string $date=null): array
    {
        $q=['from'=>$from,'to'=>$to]; if($date!==null)$q['date']=$date;
        return (array)$this->data('GET','/currencies',$q);
    }
}