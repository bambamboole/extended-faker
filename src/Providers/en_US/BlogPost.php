<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\BlogPost as BaseBlogPost;

class BlogPost extends BaseBlogPost
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
