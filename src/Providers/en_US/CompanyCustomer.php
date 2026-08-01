<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\CompanyCustomer as BaseCompanyCustomer;

class CompanyCustomer extends BaseCompanyCustomer
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
