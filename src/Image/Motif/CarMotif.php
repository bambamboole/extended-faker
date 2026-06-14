<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class CarMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M18 58 l8 -18 h48 l8 18 v8 h-72 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M32 42 h36 l4 12 h-44 z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="2" stroke-linejoin="round"/>'
            .'<circle cx="33" cy="68" r="8" fill="'.$p->outline.'"/>'
            .'<circle cx="67" cy="68" r="8" fill="'.$p->outline.'"/>';
    }
}
