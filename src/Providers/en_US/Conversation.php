<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Conversation as BaseConversation;

class Conversation extends BaseConversation
{
    protected function getLocale(): string
    {
        return 'en_US';
    }
}
