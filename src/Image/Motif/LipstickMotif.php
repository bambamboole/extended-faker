<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class LipstickMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="40" y="46" width="20" height="36" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M42 46 V30 L58 24 V46 Z" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>';
    }
}
