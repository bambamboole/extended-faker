<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ImageDto;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;
use Faker\Factory;

function productProvider(): Product
{
    $faker = Factory::create('en_US');
    $provider = new Product($faker);
    $faker->addProvider($provider);

    return $provider;
}

it('generates a deterministic product by seed', function () {
    $provider = productProvider();

    expect($provider->generateProduct(5)->toArray())->toBe($provider->generateProduct(5)->toArray());
});

it('returns a product by its generated sku', function () {
    $provider = productProvider();
    $made = $provider->generateProduct(88);

    expect($provider->productBySku($made->sku)->toArray())->toBe($made->toArray());
});

it('exposes name, category and image accessors', function () {
    $provider = productProvider();
    $made = $provider->generateProduct(3);

    expect($provider->productName($made->sku))->toBe($made->name)
        ->and($provider->productImage($made->sku))->toBe($made->image?->path)
        ->and($provider->productImageDto($made->sku))->toBeInstanceOf(ImageDto::class);
});

it('yields far more than 1819 unique products via unique()', function () {
    $faker = Factory::create('en_US');
    $faker->addProvider(new Product($faker));

    $seen = [];
    for ($i = 0; $i < 5000; $i++) {
        $seen[$faker->unique()->product()->sku] = true;
    }

    expect(count($seen))->toBe(5000);
})->group('scale');
