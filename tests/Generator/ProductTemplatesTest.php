<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductTemplates;

it('loads templates and maps prefixes to categories', function () {
    $templates = new ProductTemplates;

    expect($templates->categories())->toContain('cell-phones-smartphones')
        ->and($templates->get('cell-phones-smartphones')['skuPrefix'])->toBe('PH')
        ->and($templates->prefixFor('cell-phones-smartphones'))->toBe('PH')
        ->and($templates->categoryForPrefix('PH'))->toBe('cell-phones-smartphones')
        ->and($templates->categoryForPrefix('ZZ'))->toBeNull();
});
