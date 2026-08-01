<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\PrivateCustomer as BasePrivateCustomer;

class PrivateCustomer extends BasePrivateCustomer
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
