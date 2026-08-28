<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

enum ConversationStatus: string
{
    case Open = 'open';
    case Resolved = 'resolved';
}
