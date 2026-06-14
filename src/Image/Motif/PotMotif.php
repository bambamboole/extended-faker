<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PotMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="22" y="50" width="10" height="6" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="68" y="50" width="10" height="6" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M26 46 H74 V70 a6 6 0 0 1 -6 6 H32 a6 6 0 0 1 -6 -6 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="22" y="38" width="56" height="9" rx="4" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="46" y="30" width="8" height="8" rx="2" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
