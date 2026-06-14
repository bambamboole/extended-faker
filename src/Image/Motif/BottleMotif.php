<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class BottleMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="36" y="40" width="28" height="42" rx="7" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="44" y="30" width="12" height="12" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="46" y="18" width="8" height="12" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M46 22 H34" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>';
    }
}
