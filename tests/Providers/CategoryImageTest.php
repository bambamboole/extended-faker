<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

it('exposes an image path on every category resolving to a committed webp', function () {
    $repo = new CategoryRepository;

    foreach ($repo->getAllCategories('en_US') as $category) {
        expect($category)->toHaveKey('image');
        expect($category['image'])->toStartWith('images/categories/');

        $path = __DIR__.'/../../resources/'.$category['image'];
        expect(file_exists($path))->toBeTrue("missing {$category['image']}");
    }
});
