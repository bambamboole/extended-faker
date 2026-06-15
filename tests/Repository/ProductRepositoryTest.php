<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('round-trips a generated product by sku', function () {
    $repo = new ProductRepository;
    $made = $repo->generate(12345, null, 'en_US');

    expect($repo->getProductBySku($made->sku, 'en_US')->toArray())->toBe($made->toArray());
});

it('returns null for an unknown prefix', function () {
    expect((new ProductRepository)->getProductBySku('ZZ-1', 'en_US'))->toBeNull();
});

it('generates a bounded batch and a category-filtered batch', function () {
    $repo = new ProductRepository;

    expect($repo->getAllProducts('en_US', 25))->toHaveCount(25);

    $shoes = $repo->getProductsByCategory('shoes-footwear', 'en_US', 10);
    expect($shoes)->toHaveCount(10);
    foreach ($shoes as $p) {
        expect($p->sku)->toStartWith('SH-');
    }
});

it('produces a ProductDto from a random seed', function () {
    expect((new ProductRepository)->getRandomProduct('en_US'))->toBeInstanceOf(ProductDto::class);
});
