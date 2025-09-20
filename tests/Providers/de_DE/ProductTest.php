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

// Product Lookup Functionality Tests

test('product name lookup returns specific german product', function () {
    $productName = $this->faker->productName('Samsung Galaxy S24 Ultra');

    expect($productName)->toBe('Samsung Galaxy S24 Ultra');
});

test('product description lookup returns specific german description', function () {
    $description = $this->faker->productDescription('Samsung Galaxy S24 Ultra');

    expect($description)->toBe('Hochmodernes Smartphone mit 6,8 Zoll Dynamic AMOLED Display, 200MP Kamera und bis zu 1TB Speicher. Perfekt für Fotografen und Tech-Enthusiasten.');
});

test('product category lookup returns specific german category', function () {
    $category = $this->faker->productCategory('Samsung Galaxy S24 Ultra');

    expect($category)->toBe('Smartphones & Handys');
});

test('product lookup returns complete german product data', function () {
    $product = $this->faker->product('Samsung Galaxy S24 Ultra');

    expect($product)
        ->toBeArray()
        ->toHaveKeys(['name', 'description', 'category'])
        ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra')
        ->and($product['description'])->toBe('Hochmodernes Smartphone mit 6,8 Zoll Dynamic AMOLED Display, 200MP Kamera und bis zu 1TB Speicher. Perfekt für Fotografen und Tech-Enthusiasten.')
        ->and($product['category'])->toBe('Smartphones & Handys');
});

test('german product lookup maintains data consistency across calls', function () {
    $name = 'IKEA Billy Bücherregal';

    $productName = $this->faker->productName($name);
    $description = $this->faker->productDescription($name);
    $category = $this->faker->productCategory($name);
    $completeProduct = $this->faker->product($name);

    expect($productName)->toBe($name);
    expect($completeProduct['name'])->toBe($productName);
    expect($completeProduct['description'])->toBe($description);
    expect($completeProduct['category'])->toBe($category);
    expect($completeProduct['category'])->toBe('Möbel');
});

test('german provider available product names contains expected products', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect($availableNames)->toContain('Samsung Galaxy S24 Ultra');
    expect($availableNames)->toContain('MacBook Air M2');
    expect($availableNames)->toContain('IKEA Billy Bücherregal');
    expect($availableNames)->toContain('Ritter Sport Schokolade');
    expect($availableNames)->toContain('Haribo Goldbären 200g');
});

test('german provider all available products can be looked up', function () {
    $availableNames = $this->faker->getAvailableProductNames();

    expect(count($availableNames))->toBeGreaterThan(40, 'Should have many German products');

    // Test a sample of products
    $sampleNames = array_slice($availableNames, 0, 10);

    foreach ($sampleNames as $name) {
        $product = $this->faker->product($name);
        expect($product['name'])->toBe($name);
        expect($product['description'])->toBeString()->not->toBeEmpty();
        expect($product['category'])->toBeString()->not->toBeEmpty();
    }
});

test('german product lookup throws exception for non-existent product', function () {
    expect(fn() => $this->faker->productName('Nicht-existierendes Produkt'))
        ->toThrow(InvalidArgumentException::class, 'Product \'Nicht-existierendes Produkt\' not found in available products.');
});

test('german product descriptions contain german language', function () {
    $sampleNames = ['Samsung Galaxy S24 Ultra', 'IKEA Billy Bücherregal', 'Ritter Sport Schokolade'];

    foreach ($sampleNames as $name) {
        $description = $this->faker->productDescription($name);

        // Check for German-specific words/patterns
        $germanIndicators = ['mit', 'für', 'und', 'der', 'die', 'das', 'aus', 'bei'];
        $containsGerman = false;

        foreach ($germanIndicators as $indicator) {
            if (stripos($description, $indicator) !== false) {
                $containsGerman = true;
                break;
            }
        }

        expect($containsGerman)->toBeTrue("Description for {$name} should contain German language indicators");
    }
});
