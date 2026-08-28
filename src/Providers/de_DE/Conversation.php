<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Conversation as BaseConversation;

class Conversation extends BaseConversation
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }
}
