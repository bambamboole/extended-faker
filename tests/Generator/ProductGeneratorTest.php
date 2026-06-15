<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Generator\ProductGenerator;
use Bambamboole\ExtendedFaker\Generator\ProductSku;
use Bambamboole\ExtendedFaker\Generator\ProductTemplates;

it('generates a deterministic product for a seed', function () {
    $gen = new ProductGenerator;

    $a = $gen->generate(42, 'cell-phones-smartphones', 'en_US');
    $b = $gen->generate(42, 'cell-phones-smartphones', 'en_US');

    expect($a)->toBeInstanceOf(ProductDto::class)
        ->and($a->toArray())->toBe($b->toArray())
        ->and($a->sku)->toStartWith('PH-')
        ->and(ProductSku::decode($a->sku))->toBe(['prefix' => 'PH', 'seed' => 42])
        ->and($a->image)->not->toBeNull();
});

it('keeps sku, category and name identical across locales but localizes the description', function () {
    $gen = new ProductGenerator;

    $en = $gen->generate(7, 'cell-phones-smartphones', 'en_US');
    $de = $gen->generate(7, 'cell-phones-smartphones', 'de_DE');

    expect($de->sku)->toBe($en->sku)
        ->and($de->name)->toBe($en->name)
        ->and($de->description)->not->toBe($en->description);
});

it('picks a category from the seed when none is given', function () {
    $gen = new ProductGenerator;
    $product = $gen->generate(999);

    expect($product->sku)->toContain('-')
        ->and($product->category)->toBeString()->not->toBe('');
});

it('generates identically whether the picked category is implicit or explicit', function () {
    $gen = new ProductGenerator;
    $implicit = $gen->generate(2024);
    $decoded = ProductSku::decode($implicit->sku);
    $explicit = $gen->generate(2024, (new ProductTemplates)->categoryForPrefix($decoded['prefix']));
    expect($explicit->toArray())->toBe($implicit->toArray());
});
