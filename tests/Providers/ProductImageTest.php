<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('gives every generated product a committed category image', function () {
    $repo = new ProductRepository;

    for ($seed = 0; $seed < 40; $seed++) {
        $product = $repo->generate($seed, null, 'en_US');

        expect($product->image)->not->toBeNull()
            ->and($product->image->path)->toStartWith('images/categories/');

        $absolute = __DIR__.'/../../resources/'.$product->image->path;
        expect(file_exists($absolute))->toBeTrue("missing {$product->image->path}");
        expect(substr((string) file_get_contents($absolute), 0, 4))->toBe('RIFF');
    }
});
