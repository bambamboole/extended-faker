<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\BlogPost as BaseBlogPost;

class BlogPost extends BaseBlogPost
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
