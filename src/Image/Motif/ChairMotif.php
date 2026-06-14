<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ChairMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="24" y="48" width="9" height="22" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="67" y="48" width="9" height="22" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M30 42 q0 -12 10 -12 h20 q10 0 10 12 v20 h-40 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<path d="M32 70 V80 M68 70 V80" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>';
    }
}
