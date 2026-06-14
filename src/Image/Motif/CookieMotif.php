<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class CookieMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<circle cx="50" cy="50" r="26" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<circle cx="42" cy="42" r="3" fill="'.$p->outline.'"/>'
            .'<circle cx="59" cy="45" r="3.5" fill="'.$p->outline.'"/>'
            .'<circle cx="45" cy="58" r="3" fill="'.$p->outline.'"/>'
            .'<circle cx="60" cy="60" r="2.6" fill="'.$p->outline.'"/>'
            .'<circle cx="52" cy="50" r="2.4" fill="'.$p->outline.'"/>';
    }
}
