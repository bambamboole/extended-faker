<?php declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Bambamboole\ExtendedFaker\Providers\Product;

beforeEach(function () {
    $this->faker = FakerFactory::create();
    $this->faker->addProvider(new Product($this->faker));
});

test('product name returns string', function () {
    $productName = $this->faker->productName();

    expect($productName)->toBeString()->not->toBeEmpty();
});

test('product description returns string', function () {
    $description = $this->faker->productDescription();

    expect($description)->toBeString()->not->toBeEmpty();
});

test('product category returns string', function () {
    $category = $this->faker->productCategory();

    expect($category)->toBeString()->not->toBeEmpty();
});

test('product returns complete array', function () {
    $product = $this->faker->product();

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category'])
        ->and($product['name'])->toBeString()->not->toBeEmpty()
        ->and($product['description'])->toBeString()->not->toBeEmpty()
        ->and($product['category'])->toBeString()->not->toBeEmpty();
});

test('product name varies between calls', function () {
    $names = [];

    // Generate multiple names to test variety
    for ($i = 0; $i < 20; $i++) {
        $names[] = $this->faker->productName();
    }

    // Should have some variety (not all identical)
    $uniqueNames = array_unique($names);
    expect(count($uniqueNames))->toBeGreaterThan(1, 'Product names should vary between calls');
});

test('product description varies between calls', function () {
    $descriptions = [];

    // Generate multiple descriptions to test variety
    for ($i = 0; $i < 20; $i++) {
        $descriptions[] = $this->faker->productDescription();
    }

    // Should have some variety (not all identical)
    $uniqueDescriptions = array_unique($descriptions);
    expect(count($uniqueDescriptions))->toBeGreaterThan(1, 'Product descriptions should vary between calls');
});

test('product uses default data', function () {
    $productName = $this->faker->productName();
    $category = $this->faker->productCategory();

    // Test that we get data from the base provider's default arrays
    expect($productName)->toBeIn([
        'Generic Product',
        'Standard Item',
        'Basic Product',
        'Essential Item',
        'Universal Product',
    ]);

    expect($category)->toBeIn([
        'Electronics',
        'Clothing',
        'Home & Garden',
        'Books',
        'Food',
        'Sports',
        'Automotive',
        'Health',
    ]);
});

test('methods are callable', function () {
    // Test that methods are callable (Faker uses magic methods, so method_exists may not work)
    expect(fn() => $this->faker->productName())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productName())->toBeString()
        ->and(fn() => $this->faker->productDescription())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productDescription())->toBeString()
        ->and(fn() => $this->faker->productCategory())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productCategory())->toBeString()
        ->and(fn() => $this->faker->product())
        ->not->toThrow(Exception::class)
        ->and($this->faker->product())->toBeArray();

});
