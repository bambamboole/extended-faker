<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\CompanyCustomer as BaseCompanyCustomer;

class CompanyCustomer extends BaseCompanyCustomer
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
