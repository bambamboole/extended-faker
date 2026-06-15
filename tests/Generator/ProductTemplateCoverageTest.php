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
