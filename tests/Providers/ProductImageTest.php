<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ImageDto;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;
use Faker\Factory as FakerFactory;

it('exposes an image path that resolves to a committed webp', function () {
    $repo = new ProductRepository;

    foreach ($repo->getAllProducts('en_US') as $product) {
        expect($product->image)->toBeInstanceOf(ImageDto::class);

        $path = __DIR__.'/../../resources/'.$product->image->path;
        expect($product->image->path)->toStartWith('images/products/')
            ->and($product->image->absolutePath)->toBe((string) realpath($path))
            ->and($product->image->mimeType)->toBe('image/webp')
            ->and($product->image->size)->toBe(filesize($path))
            ->and(substr((string) file_get_contents($path), 0, 4))->toBe('RIFF');
    }
});

it('exposes product image formatters', function () {
    $faker = FakerFactory::create();
    $faker->addProvider(new Product($faker));

    $image = $faker->productImageDto('PHONE-001-256GB-TITANIUMBLACK');

    expect($faker->productImage('PHONE-001-256GB-TITANIUMBLACK'))
        ->toBe('images/products/PHONE-001.webp')
        ->and($image)->toBeInstanceOf(ImageDto::class)
        ->and($image->absolutePath)->toEndWith('/resources/images/products/PHONE-001.webp');
});
