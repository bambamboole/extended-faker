<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class InfoMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="50" cy="50" r="27" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<circle cx="50" cy="39" r="3.5" fill="'.$p->background.'"/>'
            .'<rect x="46.5" y="46" width="7" height="20" rx="2" fill="'.$p->background.'"/>';
    }
}
