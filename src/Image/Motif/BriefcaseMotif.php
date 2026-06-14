<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class BriefcaseMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M42 40 v-6 a4 4 0 0 1 4 -4 h8 a4 4 0 0 1 4 4 v6" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round"/>'
            .'<rect x="24" y="40" width="52" height="34" rx="5" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<rect x="44" y="52" width="12" height="9" rx="2" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
