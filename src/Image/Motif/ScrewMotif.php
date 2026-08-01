<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ScrewMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="50" cy="26" r="12" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M42 26 H58" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>'
            .'<path d="M44 38 H56 L54 74 L50 82 L46 74 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M45 46 L55 42 M45 54 L55 50 M45 62 L55 58 M46 70 L54 66" fill="none" stroke="'.$p->outline.'" stroke-width="2" stroke-linecap="round"/>';
    }
}
