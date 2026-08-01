<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductGenerator;
use Bambamboole\ExtendedFaker\Generator\ProductTemplates;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

it('has a template for every category that has an image, with a unique prefix', function () {
    $templates = new ProductTemplates;
    $categoryKeys = (new CategoryRepository)->getAllCategoryKeys();

    $prefixes = [];
    foreach ($templates->categories() as $category) {
        expect($categoryKeys)->toContain($category);
        $prefix = $templates->prefixFor($category);
        expect($prefixes)->not->toContain($prefix);
        $prefixes[] = $prefix;
    }

    expect(count($templates->categories()))->toBe(count($categoryKeys));
});

it('generates a structurally valid product for every category in both locales', function () {
    $gen = new ProductGenerator;
    $templates = new ProductTemplates;

    foreach ($templates->categories() as $category) {
        foreach (['en_US', 'de_DE'] as $locale) {
            $p = $gen->generate(1, $category, $locale);
            expect($p->name)->not->toContain('{', "unfilled placeholder in {$category} name")
                ->and($p->description)->not->toContain('{', "unfilled placeholder in {$category} description")
                ->and($p->image)->not->toBeNull();
        }
    }
});

it('defines valid unitVariants and priceRange in every template', function () {
    $templates = new ProductTemplates;
    $validUnits = ['pc', 'l', 'kg', 'm', 'm2', 'set'];

    foreach ($templates->categories() as $category) {
        $t = $templates->get($category);

        expect($t)->toHaveKeys(['unitVariants', 'priceRange'], "missing unit/price keys in {$category}");
        expect($t['unitVariants'])->not->toBeEmpty();
        foreach ($t['unitVariants'] as $variant) {
            expect($variant['amount'])->toBeGreaterThan(0)
                ->and($validUnits)->toContain($variant['unit'])
                ->and($variant['label'])->toBeString()->not->toBe('');
        }
        expect($t['priceRange']['min'])->toBeGreaterThan(0)
            ->and($t['priceRange']['max'])->toBeGreaterThanOrEqual($t['priceRange']['min']);
    }
});
