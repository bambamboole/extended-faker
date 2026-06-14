<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class NewspaperMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="24" y="30" width="52" height="44" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="30" y="36" width="40" height="9" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<rect x="52" y="50" width="18" height="16" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<path d="M30 51 h16 M30 57 h16 M30 63 h16" fill="none" stroke="'.$p->outline.'" stroke-width="2.5" stroke-linecap="round"/>';
    }
}
