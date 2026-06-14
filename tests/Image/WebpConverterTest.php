<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\ComicSvgGenerator;
use Bambamboole\ExtendedFaker\Image\WebpConverter;

it('converts svg to a valid webp blob', function () {
    if (! extension_loaded('imagick')) {
        $this->markTestSkipped('ext-imagick not installed');
    }

    $svg = (new ComicSvgGenerator)->generate('coffee-tea');
    $webp = (new WebpConverter)->toWebp($svg, 256, 256);

    expect(substr($webp, 0, 4))->toBe('RIFF')
        ->and(substr($webp, 8, 4))->toBe('WEBP');
});
