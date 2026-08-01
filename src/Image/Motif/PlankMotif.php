<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PlankMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="20" y="30" width="60" height="14" rx="3" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="26" y="46" width="60" height="14" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="16" y="62" width="60" height="14" rx="3" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M30 37 H50 M36 53 H60 M26 69 H44" fill="none" stroke="'.$p->outline.'" stroke-width="2" stroke-linecap="round"/>';
    }
}
