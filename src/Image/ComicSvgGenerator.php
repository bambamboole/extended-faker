<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

final class ComicSvgGenerator
{
    public function __construct(
        private readonly MotifRegistry $registry = new MotifRegistry,
        private readonly PaletteBook $palettes = new PaletteBook,
    ) {}

    public function generate(string $motifKey, ?string $paletteSeed = null, ?Palette $palette = null): string
    {
        $palette ??= $this->palettes->pick($paletteSeed ?? $motifKey);
        $body = $this->registry->for($motifKey)->draw($palette);

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">'
            .'<rect width="100" height="100" rx="12" fill="'.$palette->background.'"/>'
            .$body
            .'</svg>';
    }
}
