<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class TagMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M26 34 h30 l20 16 -20 16 h-30 z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<circle cx="37" cy="50" r="4.5" fill="'.$p->background.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
