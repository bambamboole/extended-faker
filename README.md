# Extended Faker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bambamboole/extended-faker.svg?style=flat-square)](https://packagist.org/packages/bambamboole/extended-faker)
[![Total Downloads](https://img.shields.io/packagist/dt/bambamboole/extended-faker.svg?style=flat-square)](https://packagist.org/packages/bambamboole/extended-faker)
![GitHub Actions](https://github.com/bambamboole/extended-faker/actions/workflows/ci.yml/badge.svg)

PHP package extending [FakerPHP/Faker](https://github.com/FakerPHP/Faker) with realistic product, category, blog post, and page data. Products are generated from compositional templates (effectively unlimited, trademark-free). Provides 19+ categories, 12 fixture-backed pages, and **dynamically generates 1000+ unique blog posts** with localized content across English (en_US) and German (de_DE).

## Features

- **Cross-language consistency**: Same identifiers across locales with localized content
- **Multiple data types**: Products, categories, blog posts, and pages
- **Dynamic blog post generation**: Compositional template system generates 1000+ unique blog posts
- **Markdown blog posts**: Professional content with headings, code blocks, and rich formatting
- **Fixture-backed pages**: Named pages composed of structured Content blocks, renderable to Markdown or WordPress block markup
- **Realistic data**: Synthetic, trademark-free product names, descriptions, categories, and dynamically composed articles
- **Deterministic generation**: Same seed produces same blog post for reproducible testing
- **Extensible**: Easy to add new data via JSON template files

## Installation

```bash
composer require bambamboole/extended-faker
```

## Usage

### Products

Products are generated deterministically from compositional templates, so
`$faker->unique()->product()` yields effectively unlimited unique products
(synthetic, trademark-free names like "Voltari Pulse 7 Pro 256GB Graphite").

```php
use Faker\Factory;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;

$faker = Factory::create('en_US');
$faker->addProvider(new Product($faker));

$product = $faker->product();              // random ProductDto
$product = $faker->generateProduct(42);    // deterministic by seed
$same    = $faker->productBySku($product->sku); // round-trips to the same product
$de      = $faker->getProductInLocale($product->sku, 'de_DE'); // same SKU, localized
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

### Pages

```php
use Bambamboole\ExtendedFaker\Providers\en_US\Page;
use Bambamboole\ExtendedFaker\Page\PageType;

$faker->addProvider(new Page($faker));

// Named fixture-backed page
$page = $faker->page('about');
// PageDto with title, slug, content blocks, excerpt, template, seo, etc.

// Typed page lookup
$pricing = $faker->page(PageType::Pricing);
$about = $faker->pageByType(PageType::About);

// Render page content
$content = $faker->pageContent('about');      // Markdown content
$blocks = $faker->pageBlockContent('about');  // WordPress block markup
$seo = $faker->pageSeo('about');              // SEO title and description

// Cross-locale pages work with shared slugs
$dePage = $faker->getPageInLocale($page->slug, 'de_DE');
$aboutPage = $faker->pageBySlug('about', 'en_US');
```

### Using ExtendedFaker Helper

For convenience, use the `ExtendedFaker::extend()` method to register all providers at once:

```php
use Faker\Factory;
use Bambamboole\ExtendedFaker\ExtendedFaker;

// Automatically registers Product, Category, BlogPost, and Page providers
$faker = Factory::create('en_US');
ExtendedFaker::extend($faker, 'en_US');

// Now use any provider
$product = $faker->product();
$category = $faker->category();
$blogPost = $faker->blogPost();
$page = $faker->page();

// German locale
$fakerDe = Factory::create('de_DE');
ExtendedFaker::extend($fakerDe, 'de_DE');
```

## Available Methods

### Product Provider
- `productName(?string $identifier = null): string`
- `productDescription(?string $identifier = null): string`
- `productCategory(?string $identifier = null): string`
- `product(?string $identifier = null): ProductDto`
- `generateProduct(int $seed, ?string $category = null, ?string $locale = null): ProductDto`
- `productBySku(string $sku, ?string $locale = null): ProductDto`
- `getProductInLocale(string $sku, string $locale): ProductDto`

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

### Page Provider
- `pageTitle(string|PageType|null $identifier = null): string`
- `pageContent(string|PageType|null $identifier = null): string`
- `pageBlockContent(string|PageType|null $identifier = null, ?WordPressBlockOptions $options = null): string`
- `pageExcerpt(string|PageType|null $identifier = null): string`
- `pageTemplate(string|PageType|null $identifier = null): string`
- `pageSeo(string|PageType|null $identifier = null): array`
- `page(string|PageType|null $identifier = null): PageDto`
- `pageByType(PageType $page, ?string $locale = null): PageDto`
- `pageBySlug(string $slug, ?string $locale = null): PageDto`
- `getPageSlug(string $title): string`
- `getPageInLocale(string $slug, string $locale): PageDto`

## Data Structure

Categories and pages are stored as JSON files. Products and blog posts are dynamically generated from composable templates:

```
resources/
├── categories/
│   ├── cell-phones-smartphones.json
│   ├── electronics.json
│   └── ...
├── pages/
│   ├── about.json
│   ├── contact.json
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

## Fixture Images

Every product, category, and page exposes a small, copyright-safe **comic image**
(bold-outline SVG rasterized to WebP, committed under `resources/images/`).

```php
$faker->productImageDto();              // ImageDto -> images/products/{category}/{n}.webp
$faker->productImage();                 // path, e.g. "images/products/cell-phones-smartphones/3.webp"
$faker->category()['image'];            // "images/categories/electronics.webp"
$faker->page('about')->image;           // "images/pages/about.webp"
$faker->pageImage('about');             // same path
```

Each generated product gets a committed WebP matching its **category and colour**: every
category's comic motif is rendered in each palette, and a product points to the palette
that matches its colour (so products sharing a category and colour share an image). The
`ImageDto` exposes the relative path plus the resolved absolute path and file metadata. The
shipped package only reads the committed WebP files. To regenerate the set, run
`npm install && composer images:build` — rasterization uses Node + [sharp](https://sharp.pixelplumbing.com).
See the `creating-fixture-images` skill for the motif system.

## Requirements

- PHP 8.3+
- fakerphp/faker ^1.24
- league/commonmark ^2.7
- symfony/yaml ^7.3

## Testing

```bash
composer test            # run the test suite
composer test:coverage   # run with coverage
composer test:lint       # check code style (Pint)
composer analyse         # static analysis (PHPStan)
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email manuel@christlieb.eu instead of using the issue tracker.

## Credits

- [Manuel Christlieb](https://github.com/bambamboole)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
