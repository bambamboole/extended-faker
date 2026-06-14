<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ShirtMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M35 25 l-15 12 6 10 9 -5 v33 h40 v-33 l9 5 6 -10 -15 -12 -8 4 a9 6 0 0 1 -16 0 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
