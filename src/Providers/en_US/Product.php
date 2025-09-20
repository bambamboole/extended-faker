<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Product as BaseProduct;

class Product extends BaseProduct
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
