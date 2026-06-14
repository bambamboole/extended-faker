<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

interface Motif
{
    /** Returns inner SVG markup drawn within a 0 0 100 100 viewBox. */
    public function draw(Palette $palette): string;
}
