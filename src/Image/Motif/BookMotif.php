<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class BookMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="28" y="24" width="44" height="56" rx="4" fill="'.$p->primary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M38 24 V80" fill="none" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M44 34 H66 M44 42 H66" fill="none" stroke="'.$p->outline.'" stroke-width="2" stroke-linecap="round"/>'
            .'<rect x="58" y="24" width="8" height="20" fill="'.$p->accent.'" stroke="'.$p->outline.'" stroke-width="2"/>';
    }
}
