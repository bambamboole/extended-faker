<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

final readonly class Palette
{
    public function __construct(
        public string $background,
        public string $outline,
        public string $primary,
        public string $secondary,
        public string $accent,
    ) {}
}
