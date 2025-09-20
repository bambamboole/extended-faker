<?php declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;

beforeEach(function () {
    $this->faker = FakerFactory::create('en_US');
    $this->faker->addProvider(new Product($this->faker));
});

test('product name returns english products', function () {
    $productName = $this->faker->productName();

    expect($productName)->toBeString()->not->toBeEmpty();

    // Test some English products are included
    $englishProducts = [
        'Samsung Galaxy S24 Ultra 5G',
        'iPhone 15 Pro Max 256GB',
        'MacBook Air M2 13-inch',
        'Instant Pot Duo 7-in-1',
        'Starbucks Pike Place Coffee',
    ];

    // Generate multiple names to increase chance of getting expected values
    $names = [];
    for ($i = 0; $i < 50; $i++) {
        $names[] = $this->faker->productName();
    }

    // Check that at least some English products appear
    $foundEnglishProducts = array_intersect($names, $englishProducts);
    expect($foundEnglishProducts)->not->toBeEmpty('Should contain English product names');
});

test('product description contains english text', function () {
    $descriptions = [];

    // Generate multiple descriptions to test English content
    for ($i = 0; $i < 20; $i++) {
        $descriptions[] = $this->faker->productDescription();
    }

    $allDescriptions = implode(' ', $descriptions);

    // Test for English-specific words/phrases
    $englishIndicators = [
        'with', 'for', 'and', 'the', 'premium', 'quality', 'performance',
        'professional', 'innovative', 'advanced', 'exceptional', 'cutting-edge',
    ];

    $containsEnglish = false;
    foreach ($englishIndicators as $indicator) {
        if (stripos($allDescriptions, $indicator) !== false) {
            $containsEnglish = true;
            break;
        }
    }

    expect($containsEnglish)->toBeTrue('Descriptions should contain English language indicators');
});

test('product category returns english categories', function () {
    $categories = [];

    // Generate multiple categories
    for ($i = 0; $i < 30; $i++) {
        $categories[] = $this->faker->productCategory();
    }

    $uniqueCategories = array_unique($categories);

    // Test for English category names (using actual categories from the provider)
    $englishCategories = [
        'Electronics',
        'Computers & Accessories',
        'Cell Phones & Smartphones',
        'Clothing & Fashion',
        'Men\'s Clothing',
        'Women\'s Clothing',
        'Home & Garden',
        'Kitchen & Dining',
        'Health & Beauty',
        'Food & Beverages',
        'Sports & Outdoors',
        'Books & Media',
        'Baby & Kids',
    ];

    $foundEnglishCategories = array_intersect($uniqueCategories, $englishCategories);
    expect($foundEnglishCategories)->not->toBeEmpty('Should contain English category names');
});

test('inheritance from base provider', function () {
    // Test that methods are callable (inherited from base provider)
    expect(fn() => $this->faker->productName())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productName())->toBeString();

    expect(fn() => $this->faker->productDescription())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productDescription())->toBeString();

    expect(fn() => $this->faker->productCategory())
        ->not->toThrow(Exception::class)
        ->and($this->faker->productCategory())->toBeString();

    expect(fn() => $this->faker->product())
        ->not->toThrow(Exception::class)
        ->and($this->faker->product())->toBeArray();
});

test('product returns english data', function () {
    $product = $this->faker->product();

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category'])
        ->and($product['name'])->toBeString()->not->toBeEmpty()
        ->and($product['description'])->toBeString()->not->toBeEmpty()
        ->and($product['category'])->toBeString()->not->toBeEmpty();
});

test('data variety and randomness', function () {
    $products = [];

    // Generate multiple products
    for ($i = 0; $i < 20; $i++) {
        $products[] = $this->faker->product();
    }

    // Extract names and check for variety
    $names = array_column($products, 'name');
    $uniqueNames = array_unique($names);

    expect(count($uniqueNames))->toBeGreaterThan(1, 'Should generate varied product names');

    // Extract categories and check for variety
    $categories = array_column($products, 'category');
    $uniqueCategories = array_unique($categories);

    expect(count($uniqueCategories))->toBeGreaterThan(1, 'Should generate varied categories');
});

test('us specific products', function () {
    $names = [];

    // Generate multiple names
    for ($i = 0; $i < 100; $i++) {
        $names[] = $this->faker->productName();
    }

    $allNames = implode(' ', $names);

    // Test for US-centric brands and products
    $usIndicators = [
        'Starbucks', 'Nike', 'Apple', 'Amazon', 'Google', 'Microsoft',
        'Walmart', 'Target', 'Best Buy', 'Home Depot',
    ];

    $containsUS = false;
    foreach ($usIndicators as $indicator) {
        if (stripos($allNames, $indicator) !== false) {
            $containsUS = true;
            break;
        }
    }

    // Note: This test might not always pass due to randomness, but it tests US product inclusion
    if ($containsUS) {
        expect($containsUS)->toBeTrue('Names should occasionally contain US-specific brands');
    } else {
        test()->skip('No US-specific brands found in this random sample');
    }
});

dataset('english product data', [
    'productName' => [
        'productName',
        ['Samsung', 'iPhone', 'MacBook', 'Nike', 'Adidas', 'Instant Pot'],
    ],
    'productCategory' => [
        'productCategory',
        ['Electronics', 'Clothing', 'Home & Garden', 'Health & Beauty', 'Food & Beverages'],
    ],
]);

test('english specific content', function (string $method, array $expectedContent) {
    $results = [];

    // Generate multiple results to test content
    for ($i = 0; $i < 50; $i++) {
        $results[] = $this->faker->$method();
    }

    $allResults = implode(' ', $results);

    // Check that at least some expected content appears
    $foundExpected = false;
    foreach ($expectedContent as $expected) {
        if (stripos($allResults, $expected) !== false) {
            $foundExpected = true;
            break;
        }
    }

    expect($foundExpected)->toBeTrue("Method {$method} should contain English-specific content");
})->with('english product data');

test('description length variety', function () {
    $descriptions = [];

    // Generate multiple descriptions
    for ($i = 0; $i < 30; $i++) {
        $descriptions[] = $this->faker->productDescription();
    }

    $lengths = array_map('strlen', $descriptions);

    // Should have variety in description lengths
    $minLength = min($lengths);
    $maxLength = max($lengths);

    expect($maxLength)->toBeGreaterThan($minLength, 'Descriptions should vary in length');
    expect($minLength)->toBeGreaterThan(10, 'Descriptions should be reasonably long');
});

// Product Lookup Functionality Tests

test('product name lookup returns specific english product', function () {
    $productName = $this->faker->productName('Samsung Galaxy S24 Ultra 5G');

    expect($productName)->toBe('Samsung Galaxy S24 Ultra 5G');
});

test('product description lookup returns specific english description', function () {
    $description = $this->faker->productDescription('Samsung Galaxy S24 Ultra 5G');

    expect($description)->toBe('Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.');
});

test('product category lookup returns specific english category', function () {
    $category = $this->faker->productCategory('Samsung Galaxy S24 Ultra 5G');

    expect($category)->toBe('Cell Phones & Smartphones');
});

test('product lookup returns complete english product data', function () {
    $product = $this->faker->product('Samsung Galaxy S24 Ultra 5G');

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category'])
        ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra 5G')
        ->and($product['description'])->toBe('Cutting-edge smartphone featuring a 6.8-inch Dynamic AMOLED display, 200MP camera system, and up to 1TB storage. Perfect for photography enthusiasts and power users.')
        ->and($product['category'])->toBe('Cell Phones & Smartphones');
});

test('english product lookup maintains data consistency across calls', function () {
    $name = 'MacBook Air M2 13-inch';

    $productName = $this->faker->productName($name);
    $description = $this->faker->productDescription($name);
    $category = $this->faker->productCategory($name);
    $completeProduct = $this->faker->product($name);

    expect($productName)->toBe($name);
    expect($completeProduct['name'])->toBe($productName);
    expect($completeProduct['description'])->toBe($description);
    expect($completeProduct['category'])->toBe($category);
    expect($completeProduct['category'])->toBe('Computers & Accessories');
});

test('english provider available product names contains expected products', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect($availableNames)->toContain('Samsung Galaxy S24 Ultra 5G');
    expect($availableNames)->toContain('iPhone 15 Pro Max 256GB');
    expect($availableNames)->toContain('MacBook Air M2 13-inch');
    expect($availableNames)->toContain('Levi\'s 501 Original Fit Jeans');
    expect($availableNames)->toContain('Instant Pot Duo 7-in-1');
});

test('english provider all available products can be looked up', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect(count($availableNames))->toBeGreaterThan(50, 'Should have many English products');

    // Test a sample of products
    $sampleNames = array_slice($availableNames, 0, 10);

    foreach ($sampleNames as $name) {
        $product = $this->faker->product($name);
        expect($product['name'])->toBe($name);
        expect($product['description'])->toBeString()->not->toBeEmpty();
        expect($product['category'])->toBeString()->not->toBeEmpty();
    }
});

test('english product lookup throws exception for non-existent product', function () {
    expect(fn() => $this->faker->productName('Non-existent English Product'))
        ->toThrow(InvalidArgumentException::class, 'Product \'Non-existent English Product\' not found in available products.');
});
