<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\Motif\FallbackMotif;
use Bambamboole\ExtendedFaker\Image\MotifRegistry;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('has a non-fallback motif for every category key', function () {
    $registry = new MotifRegistry;
    $keys = (new CategoryRepository)->getAllCategoryKeys();

    expect($keys)->not->toBeEmpty();

    foreach ($keys as $key) {
        expect($registry->has($key))->toBeTrue("missing motif for category '{$key}'")
            ->and($registry->for($key))->not->toBeInstanceOf(FallbackMotif::class);
    }
});

it('has a non-fallback motif for every category used by a product', function () {
    $registry = new MotifRegistry;

    foreach ((new ProductRepository)->getUsedCategories() as $key) {
        expect($registry->has($key))->toBeTrue("missing motif for product category '{$key}'");
    }
});
