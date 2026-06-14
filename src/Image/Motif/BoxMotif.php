<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class BoxMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M50 22 L78 36 V64 L50 78 L22 64 V36 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M22 36 L50 50 L78 36 M50 50 V78" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M36 29 L64 43" fill="none" stroke="'.$p->accent.'" stroke-width="3"/>';
    }
}
