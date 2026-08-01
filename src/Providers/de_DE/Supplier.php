<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Supplier as BaseSupplier;

class Supplier extends BaseSupplier
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
