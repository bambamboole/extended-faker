<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PeopleMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="64" cy="42" r="8" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M52 74 q0 -15 12 -15 q12 0 12 15 z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<circle cx="38" cy="40" r="9" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M22 74 q0 -16 16 -16 q16 0 16 16 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
