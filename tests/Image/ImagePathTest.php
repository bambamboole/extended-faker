<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\ImagePath;

it('builds the relative webp path', function () {
    expect(ImagePath::for('products', 'PHONE-002'))->toBe('images/products/PHONE-002.webp')
        ->and(ImagePath::for('pages', 'about'))->toBe('images/pages/about.webp');
});
