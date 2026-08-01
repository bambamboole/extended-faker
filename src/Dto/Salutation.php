<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

enum Salutation: string
{
    case Mr = 'mr';
    case Mrs = 'mrs';
    case Neutral = 'neutral';
    case Family = 'family';
    case Company = 'company';
}
