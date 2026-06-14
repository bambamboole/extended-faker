<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class SpeechBubbleMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M24 28 h52 a6 6 0 0 1 6 6 v28 a6 6 0 0 1 -6 6 H44 l-12 12 v-12 H24 a6 6 0 0 1 -6 -6 V34 a6 6 0 0 1 6 -6 z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M42 41 q0 -9 8 -9 q9 0 9 9 q0 7 -9 9 v3" fill="none" stroke="'.$p->outline.'" stroke-width="3.5" stroke-linecap="round"/>'
            .'<circle cx="50" cy="61" r="2.6" fill="'.$p->outline.'"/>';
    }
}
