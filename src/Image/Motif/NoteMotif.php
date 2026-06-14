<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class NoteMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M50 66 V24" fill="none" stroke="'.$p->outline.'" stroke-width="4" stroke-linecap="round"/>'
            .'<path d="M50 24 q16 4 14 22" fill="none" stroke="'.$p->outline.'" stroke-width="4" stroke-linecap="round"/>'
            .'<circle cx="40" cy="68" r="11" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>';
    }
}
