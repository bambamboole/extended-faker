<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\ImagePath;

it('builds the relative webp path', function () {
    expect(ImagePath::for('categories', 'athletic-apparel'))->toBe('images/categories/athletic-apparel.webp')
        ->and(ImagePath::for('pages', 'about'))->toBe('images/pages/about.webp');
});

it('resolves relative image paths to package resource files', function () {
    $path = ImagePath::absolute('images/categories/athletic-apparel.webp');

    expect($path)->toEndWith('/resources/images/categories/athletic-apparel.webp')
        ->and(file_exists($path))->toBeTrue()
        ->and($path)->toBe((string) realpath($path))
        ->and(substr((string) file_get_contents($path), 0, 4))->toBe('RIFF');
});
