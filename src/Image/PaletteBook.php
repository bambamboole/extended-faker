<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

final class PaletteBook
{
    /** @var list<Palette> */
    private array $palettes;

    public function __construct()
    {
        $this->palettes = [
            new Palette('#ffe9c7', '#111111', '#ff6b6b', '#ffd23f', '#4c6ef5'),
            new Palette('#d8f3dc', '#111111', '#2f9e6e', '#95d5b2', '#ff6b6b'),
            new Palette('#e0e7ff', '#111111', '#4c6ef5', '#8fd3ff', '#ffd23f'),
            new Palette('#ffe0e9', '#111111', '#e8546b', '#ff9aa2', '#4c6ef5'),
            new Palette('#ede7ff', '#111111', '#7048e8', '#b197fc', '#ffd23f'),
            new Palette('#fff3bf', '#111111', '#f59f00', '#ffe066', '#2f9e6e'),
            new Palette('#c5f6fa', '#111111', '#1098ad', '#66d9e8', '#ff6b6b'),
            new Palette('#ffe3d8', '#111111', '#ff7043', '#ffab91', '#4c6ef5'),
        ];
    }

    public function pick(string $seedKey): Palette
    {
        $n = count($this->palettes);
        $index = ((crc32($seedKey) % $n) + $n) % $n;

        return $this->palettes[$index];
    }

    /** @return list<Palette> */
    public function all(): array
    {
        return $this->palettes;
    }
}
