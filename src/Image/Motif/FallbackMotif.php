<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class FallbackMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="50" cy="50" r="26" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M50 38 v18 M50 62 v0.5" stroke="'.$p->outline.'" stroke-width="4" stroke-linecap="round"/>';
    }
}
