<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class WatchMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="40" y="14" width="20" height="72" rx="6" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="30" y="32" width="40" height="36" rx="9" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<circle cx="50" cy="50" r="4" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
