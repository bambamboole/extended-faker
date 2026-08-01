<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PlugMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="34" y="36" width="32" height="26" rx="8" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M42 36 V22 M58 36 V22" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>'
            .'<path d="M50 62 V70 Q50 80 40 80 H30" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>'
            .'<circle cx="50" cy="49" r="4" fill="'.$p->background.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
