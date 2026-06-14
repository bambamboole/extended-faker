<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image\Motif;

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Palette;

final class EnvelopeMotif implements Motif
{
    public function draw(Palette $p): string
    {
        return '<rect x="22" y="32" width="56" height="36" rx="4" fill="'.$p->secondary.'" stroke="'.$p->outline.'" stroke-width="3"/>'
            .'<path d="M24 35 L50 54 L76 35" fill="none" stroke="'.$p->outline.'" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"/>';
    }
}
