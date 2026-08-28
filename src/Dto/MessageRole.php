<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

enum MessageRole: string
{
    case Customer = 'customer';
    case Agent = 'agent';
}
