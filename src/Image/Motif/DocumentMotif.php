<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class DocumentMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M30 22 H60 L72 34 V78 H30 Z" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M60 22 V34 H72" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M38 46 h26 M38 54 h26 M38 62 h18" fill="none" stroke="'.$p->outline.'" stroke-width="2.5" stroke-linecap="round"/>';
    }
}
