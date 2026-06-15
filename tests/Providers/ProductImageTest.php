<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductTemplates;
use Bambamboole\ExtendedFaker\Image\PaletteBook;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;

it('gives every generated product a committed category+colour webp via ImageDto', function () {
    $repo = new ProductRepository;

    for ($seed = 0; $seed < 60; $seed++) {
        $product = $repo->generate($seed, null, 'en_US');

        expect($product->image)->not->toBeNull()
            ->and($product->image->path)->toStartWith('images/products/')
            ->and($product->image->path)->toEndWith('.webp')
            ->and($product->image->mimeType)->toBe('image/webp');

        expect(file_exists($product->image->absolutePath))->toBeTrue("missing {$product->image->path}");
        expect(substr((string) file_get_contents($product->image->absolutePath), 0, 4))->toBe('RIFF');
    }
});

it('uses the same image for products that share category and colour, and matches across locales', function () {
    $repo = new ProductRepository;

    $en = $repo->generate(7, 'cell-phones-smartphones', 'en_US');
    $de = $repo->generate(7, 'cell-phones-smartphones', 'de_DE');

    expect($de->image->path)->toBe($en->image->path);

    $sameColour = null;
    for ($seed = 0; $seed < 200 && $sameColour === null; $seed++) {
        if ($seed === 7) {
            continue;
        }
        $candidate = $repo->generate($seed, 'cell-phones-smartphones', 'en_US');
        if ($candidate->image->path === $en->image->path) {
            $sameColour = $candidate;
        }
    }

    expect($sameColour)->not->toBeNull()
        ->and($sameColour->image->path)->toBe($en->image->path);
});

it('has a committed webp for every category and palette index', function () {
    $paletteCount = (new PaletteBook)->count();

    foreach ((new ProductTemplates)->categories() as $category) {
        for ($index = 0; $index < $paletteCount; $index++) {
            $path = __DIR__.'/../../resources/images/products/'.$category.'/'.$index.'.webp';
            expect(file_exists($path))->toBeTrue("missing products/{$category}/{$index}.webp");
        }
    }
});
