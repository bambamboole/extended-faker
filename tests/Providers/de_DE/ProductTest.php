<?php declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Faker\Generator;
use Bambamboole\ExtendedFaker\Providers\de_DE\Product;

beforeEach(function () {
    $this->faker = FakerFactory::create('de_DE');
    $this->faker->addProvider(new Product($this->faker));
});

test('product name returns german products', function () {
    $productName = $this->faker->productName();

    expect($productName)->toBeString()->not->toBeEmpty();

    // Test some German products are included
    $germanProducts = [
        'Samsung Galaxy S24 Ultra',
        'MacBook Air M2',
        'Levi\'s 501 Original Jeans',
        'IKEA Billy Bücherregal',
        'Ritter Sport Schokolade',
    ];

    // Generate multiple names to increase chance of getting expected values
    $names = [];
    for ($i = 0; $i < 50; $i++) {
        $names[] = $this->faker->productName();
    }

    // Check that at least some German products appear
    $foundGermanProducts = array_intersect($names, $germanProducts);
    expect($foundGermanProducts)->not->toBeEmpty('Should contain German product names');
});

test('product description contains german text', function () {
    $descriptions = [];

    // Generate multiple descriptions to test German content
    for ($i = 0; $i < 20; $i++) {
        $descriptions[] = $this->faker->productDescription();
    }

    $allDescriptions = implode(' ', $descriptions);

    // Test for German-specific words/phrases
    $germanIndicators = [
        'mit', 'für', 'und', 'der', 'die', 'das', 'hochwertig', 'qualität',
        'deutschland', 'garantie', 'technologie', 'professionell',
    ];

    $containsGerman = false;
    foreach ($germanIndicators as $indicator) {
        if (stripos($allDescriptions, $indicator) !== false) {
            $containsGerman = true;
            break;
        }
    }

    expect($containsGerman)->toBeTrue('Descriptions should contain German language indicators');
});

test('product category returns german categories', function () {
    $categories = [];

    // Generate multiple categories
    for ($i = 0; $i < 30; $i++) {
        $categories[] = $this->faker->productCategory();
    }

    $uniqueCategories = array_unique($categories);

    // Test for German category names (using actual categories from the provider)
    $germanCategories = [
        'Elektronik',
        'Computer & Zubehör',
        'Herrenmode',
        'Damenmode',
        'Haus & Garten',
        'Küche & Haushalt',
        'Gesundheit & Schönheit',
        'Lebensmittel & Getränke',
        'Bücher & Medien',
        'Bücher',
    ];

    $foundGermanCategories = array_intersect($uniqueCategories, $germanCategories);
    expect($foundGermanCategories)->not->toBeEmpty('Should contain German category names');
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

test('product returns german data', function () {
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

dataset('german product data', [
    'productName' => [
        'productName',
        ['Samsung', 'iPhone', 'MacBook', 'Levi\'s', 'IKEA', 'Ritter Sport'],
    ],
    'productCategory' => [
        'productCategory',
        ['Elektronik', 'Kleidung', 'Haus & Garten', 'Gesundheit', 'Lebensmittel'],
    ],
]);

test('german specific content', function (string $method, array $expectedContent) {
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

    expect($foundExpected)->toBeTrue("Method {$method} should contain German-specific content");
})->with('german product data');
