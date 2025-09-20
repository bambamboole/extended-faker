<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Category as BaseCategory;

class Category extends BaseCategory
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
