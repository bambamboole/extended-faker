<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class CementBagMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="28" y="34" width="44" height="48" rx="4" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="28" y="24" width="44" height="10" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="36" y="48" width="28" height="16" rx="2" fill="'.$p->background.'" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<path d="M40 56 H60" fill="none" stroke="'.$p->outline.'" stroke-width="2" stroke-linecap="round"/>';
    }
}
