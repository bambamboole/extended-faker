<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ChartMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="26" y="54" width="11" height="20" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="44" y="44" width="11" height="30" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="62" y="34" width="11" height="40" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M26 46 L46 36 L62 42 L78 24" fill="none" stroke="'.$p->accent.'" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>'
            .'<path d="M70 24 H78 V32" fill="none" stroke="'.$p->accent.'" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>';
    }
}
