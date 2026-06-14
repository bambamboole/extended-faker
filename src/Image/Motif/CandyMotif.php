<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class CandyMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M34 50 L18 40 V60 Z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M66 50 L82 40 V60 Z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<circle cx="50" cy="50" r="16" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>';
    }
}
