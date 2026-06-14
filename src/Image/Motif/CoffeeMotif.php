<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class CoffeeMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M30 40 h40 l-5 42 a6 6 0 0 1 -6 5 h-12 a6 6 0 0 1 -6 -5 z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="28" y="33" width="44" height="9" rx="4" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M46 24 q4 -6 0 -12 M54 24 q4 -6 0 -12" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>';
    }
}
