<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Supplier as BaseSupplier;

class Supplier extends BaseSupplier
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
