# Extended Faker

PHP package extending [FakerPHP/Faker](https://github.com/FakerPHP/Faker) with realistic product, category, and blog post data. Provides 25+ products, 19+ categories, and **dynamically generates 1000+ unique blog posts** with localized content across English (en_US) and German (de_DE).

## Features

- **Cross-language consistency**: Same identifiers across locales with localized content
- **Multiple data types**: Products, categories, and blog posts
- **Dynamic blog post generation**: Compositional template system generates 1000+ unique blog posts
- **Markdown blog posts**: Professional content with headings, code blocks, and rich formatting
- **Realistic data**: Actual product names, descriptions, categories, and dynamically composed articles
- **Deterministic generation**: Same seed produces same blog post for reproducible testing
- **Extensible**: Easy to add new data via JSON template files

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

### Blog Posts

```php
use Bambamboole\ExtendedFaker\Providers\en_US\BlogPost;

$faker->addProvider(new BlogPost($faker));

// Random blog post (dynamically generated)
$post = $faker->blogPost();
// BlogPostDto with title, content, excerpt, tags, author, etc.

// Specific blog post methods
$title = $faker->blogPostTitle();        // "Getting Started with Docker in 2024"
$content = $faker->blogPostContent();    // Full markdown content
$excerpt = $faker->blogPostExcerpt();    // Short summary
$tags = $faker->blogPostTags();          // ["docker", "devops", "containers"]
$author = $faker->blogPostAuthor();      // "Michael Chen"
$category = $faker->blogPostCategory();  // "technology"
$readingTime = $faker->blogPostReadingTime(); // 2 (minutes)

// Get post by dynamically generated slug
$slug = $post->slug;
$retrievedPost = $faker->blogPostBySlug($slug);

// Cross-locale blog posts work with any generated slug
$enPost = $faker->blogPost();
$dePost = $faker->getBlogPostInLocale($enPost->slug, 'de_DE');
```

### Using ExtendedFaker Helper

For convenience, use the `ExtendedFaker::extend()` method to register all providers at once:

```php
use Faker\Factory;
use Bambamboole\ExtendedFaker\ExtendedFaker;

// Automatically registers Product, Category, and BlogPost providers
$faker = Factory::create('en_US');
ExtendedFaker::extend($faker, 'en_US');

// Now use any provider
$product = $faker->product();
$category = $faker->category();
$blogPost = $faker->blogPost();

// German locale
$fakerDe = Factory::create('de_DE');
ExtendedFaker::extend($fakerDe, 'de_DE');
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

### BlogPost Provider
- `blogPostTitle(?string $identifier = null): string`
- `blogPostContent(?string $identifier = null): string`
- `blogPostExcerpt(?string $identifier = null): string`
- `blogPostCategory(?string $identifier = null): string`
- `blogPostTags(?string $identifier = null): array`
- `blogPostAuthor(?string $identifier = null): string`
- `blogPostReadingTime(?string $identifier = null): int`
- `blogPost(?string $identifier = null): BlogPostDto`
- `blogPostBySlug(string $slug, ?string $locale = null): BlogPostDto`
- `getBlogPostSlug(string $title): string`
- `getBlogPostInLocale(string $slug, string $locale): BlogPostDto`

## Data Structure

Products and categories are stored as JSON files, while blog posts are dynamically generated from composable templates:

```
resources/
├── products/
│   ├── samsung-galaxy-s24.json
│   ├── iphone-15.json
│   └── ...
├── categories/
│   ├── cell-phones-smartphones.json
│   ├── electronics.json
│   └── ...
└── blog-templates/
    ├── titles.json              // Title patterns by category
    ├── introductions.json       // Opening paragraph templates
    ├── sections.json            // Body content blocks by category
    ├── conclusions.json         // Closing paragraph templates
    ├── code-examples.json       // Code snippets for tech posts
    └── metadata.json            // Authors, tags, topics, dates
```

### Blog Post Generation

Blog posts are **dynamically generated** using a compositional template system that mixes and matches components:

- **1000+ unique combinations** from template patterns
- **Deterministic generation**: Same seed always produces the same post
- **Category-specific content**: Technology, Business, Travel, Lifestyle
- **Automatic slug generation** from titles
- **Reading time calculation** based on word count (200 words/minute)
- **3-5 minute reads**: Short, focused blog posts (150-350 words)

**Available Categories:** Technology, Business, Travel, Lifestyle

Each generated post includes:
- Unique title and slug
- Category-appropriate introduction
- 4-5 content sections
- Conclusion
- 3-5 relevant tags
- Random author name
- Published date (2023-2024)
- Calculated reading time
- Optional code examples (technology posts)

## Requirements

- PHP 8.2+
- fakerphp/faker ^1.24
- league/commonmark ^2.7
- symfony/yaml ^7.3

## Testing

```bash
composer install
./vendor/bin/pest
```

## License

MIT License