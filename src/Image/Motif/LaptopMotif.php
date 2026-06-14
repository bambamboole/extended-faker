<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class LaptopMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="28" y="26" width="44" height="30" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="33" y="31" width="34" height="20" rx="2" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<path d="M20 64 H80 L84 72 H16 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
