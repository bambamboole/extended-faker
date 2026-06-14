<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class BallMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="50" cy="50" r="24" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M50 40 l10 7 -4 12 h-12 l-4 -12 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="2.5" stroke-linejoin="round"/>'
            .'<path d="M50 26 V40 M74 50 L60 47 M62 71 L56 59 M38 71 L44 59 M26 50 L40 47" fill="none" stroke="'.$p->outline.'" stroke-width="2.5"/>';
    }
}
