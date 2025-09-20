# Extended Faker

PHP package extending [FakerPHP/Faker](https://github.com/FakerPHP/Faker) with realistic product and category data from JSON files. Provides 25+ products and 19+ categories with localized content across English (en_US) and German (de_DE).

## Features

- **Cross-language consistency**: Same SKU across locales with localized names
- **JSON-based storage**: Individual files for products/categories, no hardcoded data
- **Realistic data**: Actual product names, descriptions, and categories
- **Extensible**: Easy to add new products/categories via JSON files

## Installation

```bash
composer require bambamboole/extended-faker
```

## Usage

### Basic Product Data

```php
use Faker\Factory;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;

$faker = Factory::create('en_US');
$faker->addProvider(new Product($faker));

// Random product
$product = $faker->product();
// ['name' => 'Samsung Galaxy S24 Ultra 5G', 'sku' => 'PHONE-001', ...]

// Specific product methods
$name = $faker->productName();           // "iPhone 15 Pro Max"
$description = $faker->productDescription(); // Full product description
$category = $faker->productCategory();   // "Cell Phones & Smartphones"
```

### Cross-Language Support

```php
use Bambamboole\ExtendedFaker\Providers\de_DE\Product as GermanProduct;

// English version
$englishProduct = $faker->productBySku('PHONE-001', 'en_US');
// ['name' => 'Samsung Galaxy S24 Ultra 5G', 'sku' => 'PHONE-001', ...]

// German version (same SKU, localized content)
$germanProduct = $faker->productBySku('PHONE-001', 'de_DE');
// ['name' => 'Samsung Galaxy S24 Ultra', 'sku' => 'PHONE-001', ...]
```

### Categories

```php
use Bambamboole\ExtendedFaker\Providers\en_US\Category;

$faker->addProvider(new Category($faker));

$category = $faker->category();          // Random category
$categoryName = $faker->categoryName();  // "Electronics"
```

## Available Methods

### Product Provider
- `productName(?string $identifier = null): string`
- `productDescription(?string $identifier = null): string`
- `productCategory(?string $identifier = null): string`
- `product(?string $identifier = null): array`
- `productBySku(string $sku, ?string $locale = null): array`
- `getProductSku(string $name): string`
- `getProductInLocale(string $sku, string $locale): array`

### Category Provider
- `categoryName(?string $identifier = null): string`
- `category(?string $identifier = null): array`

## Data Structure

Products and categories are stored as individual JSON files:

```
resources/
├── products/
│   ├── samsung-galaxy-s24.json
│   ├── iphone-15.json
│   └── ...
└── categories/
    ├── cell-phones-smartphones.json
    ├── electronics.json
    └── ...
```

## Requirements

- PHP 8.2+
- fakerphp/faker ^1.24

## Testing

```bash
composer install
./vendor/bin/pest
```

## License

MIT License