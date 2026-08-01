<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductGenerator;
use Bambamboole\ExtendedFaker\Generator\ProductTemplates;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('gives every product a unit and a deterministic price', function () {
    $gen = new ProductGenerator;

    $a = $gen->generate(42, 'electronics', 'en_US');
    $b = $gen->generate(42, 'electronics', 'en_US');

    expect($a->toArray())->toBe($b->toArray())
        ->and($a->unitAmount)->toBe(1.0)
        ->and($a->unit)->toBe('pc')
        ->and($a->price)->not->toBeNull()
        ->and([49, 95, 99])->toContain($a->price->amount % 100)
        ->and($a->price->currency)->toBe('USD');
});

it('keeps the price amount identical across locales but localizes the currency', function () {
    $gen = new ProductGenerator;

    $en = $gen->generate(7, 'furniture', 'en_US');
    $de = $gen->generate(7, 'furniture', 'de_DE');

    expect($de->price->amount)->toBe($en->price->amount)
        ->and($en->price->currency)->toBe('USD')
        ->and($de->price->currency)->toBe('EUR');
});

it('keeps prices within the template range for single-variant categories', function () {
    $gen = new ProductGenerator;
    $range = (new ProductTemplates)->get('snacks-candy')['priceRange'];

    foreach (range(0, 99) as $seed) {
        $p = $gen->generate($seed, 'snacks-candy', 'en_US');
        expect($p->price->amount)->toBeGreaterThanOrEqual((int) $range['min'] - 100)
            ->and($p->price->amount)->toBeLessThanOrEqual((int) $range['max'] + 100);
    }
});

it('keeps prices within the scaled range for multi-variant categories', function () {
    $gen = new ProductGenerator;
    $t = (new ProductTemplates)->get('paint-coatings');
    $reference = (float) $t['unitVariants'][0]['amount'];

    foreach (range(0, 99) as $seed) {
        $p = $gen->generate($seed, 'paint-coatings', 'en_US');
        $scale = $p->unitAmount / $reference;

        expect($p->price->amount)->toBeGreaterThanOrEqual((int) round($t['priceRange']['min'] * $scale) - 100)
            ->and($p->price->amount)->toBeLessThanOrEqual((int) round($t['priceRange']['max'] * $scale) + 100)
            ->and([49, 95, 99])->toContain($p->price->amount % 100);
    }
});

it('round-trips unit and price through the sku', function () {
    $repo = new ProductRepository;
    $made = $repo->generate(12345, null, 'en_US');

    expect($repo->getProductBySku($made->sku, 'en_US')->toArray())->toBe($made->toArray());
});
