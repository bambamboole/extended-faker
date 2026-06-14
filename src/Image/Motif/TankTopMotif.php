<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class TankTopMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M40 24 q10 9 20 0 l9 7 -7 9 -4 -2 v33 h-16 v-33 l-4 2 -7 -9 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
