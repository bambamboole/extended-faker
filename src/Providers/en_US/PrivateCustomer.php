<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\PrivateCustomer as BasePrivateCustomer;

class PrivateCustomer extends BasePrivateCustomer
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
