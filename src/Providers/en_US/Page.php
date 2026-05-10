<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Page as BasePage;

class Page extends BasePage
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
