<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class ElectronicsMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M54 14 L30 54 H46 L42 86 L70 42 H52 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
