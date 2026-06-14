<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PlantMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M50 56 V40 M50 48 q-13 -2 -15 -16 q13 0 15 14 M50 44 q13 -2 15 -16 q-13 0 -15 14" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<rect x="34" y="54" width="32" height="8" rx="2" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M37 62 H63 L59 80 H41 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
