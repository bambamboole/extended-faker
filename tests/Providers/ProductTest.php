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
        ->toHaveKeys(['name', 'description', 'category', 'sku', 'category_group'])
        ->and($product['name'])->toBeString()->not->toBeEmpty()
        ->and($product['description'])->toBeString()->not->toBeEmpty()
        ->and($product['category'])->toBeString()->not->toBeEmpty()
        ->and($product['sku'])->toBeString()->not->toBeEmpty()
        ->and($product['category_group'])->toBeString()->not->toBeEmpty();
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

test('product uses repository data', function () {
    $productName = $this->faker->productName();
    $category = $this->faker->productCategory();

    // Test that we get data from the repository (actual product names)
    $availableNames = $this->faker->getAvailableProductNames();
    expect($availableNames)->toContain($productName);

    // Test actual categories exist in the system
    expect($category)->toBeString()->not->toBeEmpty();
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

// SKU-Based Functionality Tests

test('product name with specific name returns same name', function () {
    $productName = $this->faker->productName('Samsung Galaxy S24 Ultra 5G');

    expect($productName)->toBe('Samsung Galaxy S24 Ultra 5G');
});

test('product description with specific name returns consistent description', function () {
    $description = $this->faker->productDescription('Samsung Galaxy S24 Ultra 5G');

    expect($description)->toBe('Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.');
});

test('product category with specific name returns consistent category', function () {
    $category = $this->faker->productCategory('Samsung Galaxy S24 Ultra 5G');

    expect($category)->toBe('Cell Phones & Smartphones');
});

test('product with specific name returns complete consistent data', function () {
    $product = $this->faker->product('Samsung Galaxy S24 Ultra 5G');

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category', 'sku', 'category_group'])
        ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra 5G')
        ->and($product['description'])->toBe('Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.')
        ->and($product['category'])->toBe('Cell Phones & Smartphones')
        ->and($product['sku'])->toBe('PHONE-001')
        ->and($product['category_group'])->toBe('electronics');
});

test('product lookup maintains data consistency', function () {
    // Test that all methods return consistent data for same product name
    $name = 'Samsung Galaxy S24 Ultra 5G';

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

    expect($availableNames)->toContain('Samsung Galaxy S24 Ultra 5G');
    expect($availableNames)->toContain('MacBook Air M2 13-inch');
    expect($availableNames)->toContain('Instant Pot Duo 7-in-1');
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

// SKU-Based Methods Tests

test('product by sku returns correct product', function () {
    $product = $this->faker->productBySku('PHONE-001');

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category', 'sku', 'category_group'])
        ->and($product['sku'])->toBe('PHONE-001')
        ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra 5G');
});

test('get product sku returns correct sku', function () {
    $sku = $this->faker->getProductSku('Samsung Galaxy S24 Ultra 5G');

    expect($sku)->toBe('PHONE-001');
});

test('get product in locale works correctly', function () {
    $englishProduct = $this->faker->getProductInLocale('PHONE-001', 'en_US');
    $germanProduct = $this->faker->getProductInLocale('PHONE-001', 'de_DE');

    expect($englishProduct['name'])->toBe('Samsung Galaxy S24 Ultra 5G');
    expect($germanProduct['name'])->toBe('Samsung Galaxy S24 Ultra');
    expect($englishProduct['sku'])->toBe($germanProduct['sku'])->toBe('PHONE-001');
});

test('get available skus returns array of skus', function () {
    $skus = $this->faker->getAvailableSkus();

    expect($skus)
        ->toBeArray()
        ->not->toBeEmpty()
        ->toContain('PHONE-001')
        ->toContain('LAPTOP-001')
        ->toContain('KITCHEN-001');
});

test('get supported locales returns correct locales', function () {
    $locales = $this->faker->getSupportedLocales();

    expect($locales)
        ->toBeArray()
        ->toContain('en_US')
        ->toContain('de_DE');
});

test('has product in locale works correctly', function () {
    expect($this->faker->hasProductInLocale('PHONE-001', 'en_US'))->toBeTrue();
    expect($this->faker->hasProductInLocale('PHONE-001', 'de_DE'))->toBeTrue();
    expect($this->faker->hasProductInLocale('NONEXISTENT-001', 'en_US'))->toBeFalse();
});

test('get products by category group works correctly', function () {
    $electronicsProducts = $this->faker->getProductsByCategoryGroup('electronics');

    expect($electronicsProducts)
        ->toBeArray()
        ->not->toBeEmpty();

    foreach ($electronicsProducts as $product) {
        expect($product['category_group'])->toBe('electronics');
    }
});

test('get all category groups returns array', function () {
    $categoryGroups = $this->faker->getAllCategoryGroups();

    expect($categoryGroups)
        ->toBeArray()
        ->not->toBeEmpty()
        ->toContain('electronics')
        ->toContain('fashion')
        ->toContain('home');
});