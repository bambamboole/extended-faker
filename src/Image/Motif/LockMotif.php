<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class LockMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<path d="M38 48 v-8 a12 12 0 0 1 24 0 v8" fill="none" stroke="'.$p->outline.'" stroke-width="3.5" stroke-linecap="round"/>'
            .'<rect x="30" y="48" width="40" height="32" rx="6" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<circle cx="50" cy="60" r="4" fill="'.$p->background.'"/>'
            .'<rect x="48" y="62" width="4" height="9" rx="1.5" fill="'.$p->background.'"/>';
    }
}
