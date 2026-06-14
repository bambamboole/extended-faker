<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('exposes an image path that resolves to a committed webp', function () {
    $repo = new ProductRepository;

    foreach ($repo->getAllProducts('en_US') as $product) {
        expect($product->image)->toBeString()->toStartWith('images/products/');

        $path = __DIR__.'/../../resources/'.$product->image;
        expect(file_exists($path))->toBeTrue("missing {$product->image}");
        expect(substr((string) file_get_contents($path), 0, 4))->toBe('RIFF');
    }
});
