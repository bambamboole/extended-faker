<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PhoneMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="34" y="16" width="32" height="68" rx="7" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="38" y="22" width="24" height="50" rx="3" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<circle cx="50" cy="78" r="3" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
