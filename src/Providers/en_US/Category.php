<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Category as BaseCategory;

class Category extends BaseCategory
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
