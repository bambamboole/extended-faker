<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Page as BasePage;

class Page extends BasePage
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
