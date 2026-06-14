<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ShoeMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M16 60 q0 -5 6 -7 l12 -3 13 -12 q3 -3 7 0 l3 6 16 4 q11 2 13 11 v3 q0 4 -5 4 H21 q-5 0 -5 -4z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<rect x="16" y="64" width="71" height="8" rx="4" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M40 46 l5 8 M48 43 l5 9 M56 42 l5 9" stroke="'.$p->outline.'" stroke-width="2.5" stroke-linecap="round"/>';
    }
}
