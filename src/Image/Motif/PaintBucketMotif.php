<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PaintBucketMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M30 40 Q50 24 70 40" fill="none" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M28 42 L34 80 Q35 84 40 84 H60 Q65 84 66 80 L72 42 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<ellipse cx="50" cy="42" rx="22" ry="6" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M58 46 Q60 56 58 60 Q54 62 54 56 Q54 50 58 46" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
