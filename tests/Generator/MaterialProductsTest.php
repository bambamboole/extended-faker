<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductGenerator;
use Bambamboole\ExtendedFaker\Generator\ProductTemplates;

it('generates material products with the unit label embedded in the name', function () {
    $gen = new ProductGenerator;
    $templates = new ProductTemplates;

    foreach (['paint-coatings', 'construction-wood', 'concrete-mortar'] as $category) {
        $p = $gen->generate(11, $category, 'en_US');
        $labels = array_column($templates->get($category)['unitVariants'], 'label');

        $inName = array_filter($labels, fn (string $label) => str_contains($p->name, $label));
        expect($inName)->not->toBeEmpty("no unit label in name '{$p->name}' for {$category}");
    }
});

it('uses trade-appropriate units', function () {
    $gen = new ProductGenerator;

    foreach (range(0, 30) as $seed) {
        expect($gen->generate($seed, 'paint-coatings', 'en_US')->unit)->toBe('l')
            ->and($gen->generate($seed, 'concrete-mortar', 'en_US')->unit)->toBe('kg')
            ->and($gen->generate($seed, 'construction-wood', 'en_US')->unit)->toBe('pc');
    }
});

it('localizes material category names and descriptions', function () {
    $gen = new ProductGenerator;

    $en = $gen->generate(3, 'paint-coatings', 'en_US');
    $de = $gen->generate(3, 'paint-coatings', 'de_DE');

    expect($en->category)->toBe('Paint & Coatings')
        ->and($de->category)->toBe('Farben & Lacke')
        ->and($de->sku)->toBe($en->sku)
        ->and($de->name)->toBe($en->name)
        ->and($de->description)->not->toBe($en->description);
});

it('generates fastener and electrical products with pack or length units', function () {
    $gen = new ProductGenerator;
    $templates = new ProductTemplates;

    foreach (['fasteners', 'electrical-supplies'] as $category) {
        $p = $gen->generate(23, $category, 'en_US');
        $labels = array_column($templates->get($category)['unitVariants'], 'label');

        $inName = array_filter($labels, fn (string $label) => str_contains($p->name, $label));
        expect($inName)->not->toBeEmpty("no unit label in name '{$p->name}' for {$category}");
    }

    foreach (range(0, 30) as $seed) {
        expect($gen->generate($seed, 'fasteners', 'en_US')->unit)->toBe('pc')
            ->and(['pc', 'm'])->toContain($gen->generate($seed, 'electrical-supplies', 'en_US')->unit);
    }
});

it('localizes fastener and electrical category names', function () {
    $gen = new ProductGenerator;

    expect($gen->generate(3, 'fasteners', 'en_US')->category)->toBe('Fasteners')
        ->and($gen->generate(3, 'fasteners', 'de_DE')->category)->toBe('Befestigungstechnik')
        ->and($gen->generate(3, 'electrical-supplies', 'en_US')->category)->toBe('Electrical Supplies')
        ->and($gen->generate(3, 'electrical-supplies', 'de_DE')->category)->toBe('Elektromaterial');
});
