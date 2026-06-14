<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class PlateMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="52" cy="52" r="22" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<circle cx="52" cy="52" r="13" fill="none" stroke="'.$p->outline.'" stroke-width="2"/>'
            .'<path d="M22 28 V46 M27 28 V46 M32 28 V46 M27 46 V78" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linecap="round"/>';
    }
}
