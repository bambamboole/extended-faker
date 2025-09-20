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

// Product Lookup Functionality Tests

test('product name with specific name returns same name', function () {
    $productName = $this->faker->productName('Standard Item');

    expect($productName)->toBe('Standard Item');
});

test('product description with specific name returns consistent description', function () {
    $description = $this->faker->productDescription('Standard Item');

    expect($description)->toBe('Professional-grade item with excellent durability.');
});

test('product category with specific name returns consistent category', function () {
    $category = $this->faker->productCategory('Standard Item');

    expect($category)->toBe('Clothing');
});

test('product with specific name returns complete consistent data', function () {
    $product = $this->faker->product('Standard Item');

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category'])
        ->and($product['name'])->toBe('Standard Item')
        ->and($product['description'])->toBe('Professional-grade item with excellent durability.')
        ->and($product['category'])->toBe('Clothing');
});

test('product lookup maintains data consistency', function () {
    // Test that all methods return consistent data for same product name
    $name = 'Generic Product';

    $productName = $this->faker->productName($name);
    $description = $this->faker->productDescription($name);
    $category = $this->faker->productCategory($name);
    $completeProduct = $this->faker->product($name);

    expect($productName)->toBe($name);
    expect($completeProduct['name'])->toBe($productName);
    expect($completeProduct['description'])->toBe($description);
    expect($completeProduct['category'])->toBe($category);
});

test('product lookup throws exception for non-existent product', function () {
    expect(fn() => $this->faker->productName('Non-existent Product'))
        ->toThrow(InvalidArgumentException::class, 'Product \'Non-existent Product\' not found in available products.');

    expect(fn() => $this->faker->productDescription('Non-existent Product'))
        ->toThrow(InvalidArgumentException::class);

    expect(fn() => $this->faker->productCategory('Non-existent Product'))
        ->toThrow(InvalidArgumentException::class);

    expect(fn() => $this->faker->product('Non-existent Product'))
        ->toThrow(InvalidArgumentException::class);
});

test('get available product names returns array of strings', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect($availableNames)
        ->toBeArray()
        ->not->toBeEmpty();

    foreach ($availableNames as $name) {
        expect($name)->toBeString()->not->toBeEmpty();
    }
});

test('get available product names contains expected products', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect($availableNames)->toContain('Generic Product');
    expect($availableNames)->toContain('Standard Item');
    expect($availableNames)->toContain('Basic Product');
});

test('all available product names can be looked up', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    foreach ($availableNames as $name) {
        // Should not throw exception
        expect(fn() => $this->faker->product($name))->not->toThrow(Exception::class);

        // Should return consistent data
        $product = $this->faker->product($name);
        expect($product['name'])->toBe($name);
    }
});
