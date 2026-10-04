<?php
declare(strict_types=1);
namespace ERPFlow\Api;
final class OrganizationApi extends AbstractApi
{
    public function get(): array { return (array)$this->data('GET','/organization'); }
}