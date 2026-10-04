<?php
declare(strict_types=1);
namespace ERPFlow;

/** Public API v3 contract constants and endpoint inventory. */
final class Contract
{
    public const BASE_URL = 'https://api.erpflow.hu/v3';
    public const DOCUMENT_BLOCK_TYPES = ['certificate_of_completion','dossier','invoice','offer','order_form','receipt','waybill'];
    public const DOCUMENT_TYPES = ['advance','cancellation','cert_of_completion','d_cert_of_completion','dossier','draft','draft_offer','draft_order_form','draft_waybill','invoice','modification','modified','offer','order_form','proforma','receipt','receipt_cancellation','waybill'];
    public const CREATE_DOCUMENT_TYPES = ['advance','draft','invoice','proforma'];
    public const PAYMENT_STATUSES = ['expired','none','outstanding','paid','partially_paid'];
    public const PAYMENT_METHODS = ['aruhitel','bankcard','barion','barter','cash','cash_on_delivery','coupon','elore_utalas','ep_kartya','kompenzacio','levonas','online_bankcard','other','paylike','payoneer','paypal','paypal_utolag','payu','pick_pack_pont','postai_csekk','postautalvany','skrill','szep_card','transferwise','upwork','utalvany','valto','wire_transfer'];
    public const CURRENCIES = ['AED','AUD','BGN','BRL','CAD','CHF','CNY','CZK','DKK','EUR','GBP','HKD','HRK','HUF','IDR','ILS','INR','ISK','JPY','KRW','MXN','MYR','NOK','NZD','PHP','PLN','RON','RSD','RUB','SEK','SGD','THB','TRY','UAH','USD','ZAR'];
    public const VAT_VALUES = ['27%','18%','5%','0%','AAM','TAM','F.AFA','FAD'];
    public const ENTITLEMENTS = ['AAM','ANTIQUES','ARTWORK','ATK','EAM','EUE','EUFAD37','EUFADE','HO','KBAET','NAM_1','NAM_2','SECOND_HAND','TAM','TRAVEL_AGENCY'];
    public const TAX_TYPES = ['', 'FOREIGN','HAS_TAX_NUMBER','NO_TAX_NUMBER'];
    public const DOCUMENT_FORMS = ['electronic','paper'];
    public const LANGUAGES = ['de','en','fr','hr','hu','it','ro','sk','us'];
    public const ONLINE_PAYMENTS = ['', 'Barion','SimplePay','no'];
    public const ROUNDING = ['five','none','one','ten'];
    public const SPENDING_CATEGORIES = ['advertisement','development','other','overheads','service','stock','tangible_assets'];
    public const SPENDING_DATE_FIELDS = ['due_date','invoice_date','fulfillment_date'];
    public const SPENDING_PAYMENT_STATUSES = ['paid','unpaid'];
    public const SPENDING_TYPES = ['manual','nav'];
    public const EXPORT_QUERY_TYPES = ['fulfillment_date','invoice_date'];
    public const EXPORT_SORTS = ['fulfillment_date','invoice_date','invoice_raw_number'];
    public const EXPORT_OTHER_OPTIONS = ['all','expired','outstanding'];
    public const EXPORT_TYPES = ['armada','aws_batch','ex_panda','forintsoft','hessyn','ima','infoteka','kulcs_konyv','maxitax','nagy_machinator','nav_ptgszlah','nav_status','nav_xml','nav_xml_alias','novitax','proforma_outstanding','relax','rlb','rlb60','rlb_double_entry','simple_csv','simple_excel','simple_excel_items','tensoft','tensoft_29_dot_65'];
    public const CURRENTLY_EXECUTABLE_EXPORT_TYPES = ['simple_csv'];

    /** 52 method+route combinations exposed by the audited ERPFlow API v3 router. */
    public const ENDPOINTS = [
        ['GET','/organization'],['GET','/currencies'],['GET','/utils/check-tax-number/{tax_number}'],['GET','/utils/convert-legacy-id/{id}'],['GET','/utils/time'],['GET','/server-time'],
        ['GET','/document-blocks'],['GET','/document-blocks/{id}'],
        ['GET','/bank-accounts'],['POST','/bank-accounts'],['GET','/bank-accounts/{id}'],['PUT','/bank-accounts/{id}'],['DELETE','/bank-accounts/{id}'],
        ['GET','/partners'],['POST','/partners'],['GET','/partners/{id}'],['PUT','/partners/{id}'],['DELETE','/partners/{id}'],
        ['GET','/products'],['POST','/products'],['GET','/products/{id}'],['PUT','/products/{id}'],['DELETE','/products/{id}'],
        ['GET','/documents'],['POST','/documents'],['GET','/documents/{id}'],['PUT','/documents/{id}'],['DELETE','/documents/{id}'],['GET','/documents/vendor/{vendor_id}'],['GET','/documents/{id}/download'],['GET','/documents/{id}/print/pos'],['GET','/documents/{id}/public-url'],['POST','/documents/{id}/send'],['GET','/documents/{id}/online-szamla'],['PUT','/documents/{id}/archive'],['POST','/documents/{id}/copy'],['POST','/documents/{id}/create-from-proforma'],['POST','/documents/{id}/create-modification-document'],['POST','/documents/{id}/cancel'],['GET','/documents/{id}/payments'],['PUT','/documents/{id}/payments'],['DELETE','/documents/{id}/payments'],
        ['POST','/documents/receipt'],['PUT','/documents/receipt/{id}'],
        ['GET','/spendings'],['POST','/spendings'],['GET','/spendings/{id}'],['PUT','/spendings/{id}'],['DELETE','/spendings/{id}'],
        ['POST','/document-export'],['GET','/document-export/{id}/poll'],['GET','/document-export/{id}/download'],
    ];
}
