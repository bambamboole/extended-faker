<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\ProductRepository;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

beforeEach(function () {
    $this->repository = new ProductRepository();
    // Clear both product and category caches before each test
    ProductRepository::clearCache();
    CategoryRepository::clearCache();
});

afterEach(function () {
    // Clear caches after each test
    ProductRepository::clearCache();
    CategoryRepository::clearCache();
});

describe('ProductRepository', function () {
    describe('Basic Product Loading', function () {
        test('loads products from JSON files', function () {
            $products = $this->repository->getAllProducts('en_US');

            expect($products)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($products as $product) {
                expect($product)
                    ->toHaveKeys(['sku', 'category_group', 'name', 'description', 'category'])
                    ->and($product['sku'])->toBeString()->not->toBeEmpty()
                    ->and($product['name'])->toBeString()->not->toBeEmpty()
                    ->and($product['description'])->toBeString()->not->toBeEmpty()
                    ->and($product['category'])->toBeString()->not->toBeEmpty()
                    ->and($product['category_group'])->toBeString()->not->toBeEmpty();
            }
        });

        test('gets product by SKU in English', function () {
            $product = $this->repository->getProductBySku('PHONE-001', 'en_US');

            expect($product)
                ->not->toBeNull()
                ->toHaveKeys(['sku', 'category_group', 'name', 'description', 'category'])
                ->and($product['sku'])->toBe('PHONE-001')
                ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra 5G')
                ->and($product['category'])->toBe('Cell Phones & Smartphones'); // Resolved from category key
        });

        test('gets product by SKU in German', function () {
            $product = $this->repository->getProductBySku('PHONE-001', 'de_DE');

            expect($product)
                ->not->toBeNull()
                ->toHaveKeys(['sku', 'category_group', 'name', 'description', 'category'])
                ->and($product['sku'])->toBe('PHONE-001')
                ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra')
                ->and($product['category'])->toBe('Smartphones & Handys'); // Resolved from category key
        });

        test('returns null for non-existent SKU', function () {
            $product = $this->repository->getProductBySku('NON-EXISTENT', 'en_US');
            expect($product)->toBeNull();
        });

        test('returns null for valid SKU in unsupported locale', function () {
            $product = $this->repository->getProductBySku('PHONE-001', 'fr_FR');
            expect($product)->toBeNull();
        });
    });

    describe('Product Name Lookup', function () {
        test('finds product by name', function () {
            $product = $this->repository->findProductByName('Samsung Galaxy S24 Ultra 5G', 'en_US');

            expect($product)
                ->not->toBeNull()
                ->and($product['sku'])->toBe('PHONE-001')
                ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra 5G')
                ->and($product['category'])->toBe('Cell Phones & Smartphones');
        });

        test('finds German product by German name', function () {
            $product = $this->repository->findProductByName('Samsung Galaxy S24 Ultra', 'de_DE');

            expect($product)
                ->not->toBeNull()
                ->and($product['sku'])->toBe('PHONE-001')
                ->and($product['name'])->toBe('Samsung Galaxy S24 Ultra')
                ->and($product['category'])->toBe('Smartphones & Handys');
        });

        test('returns null for non-existent product name', function () {
            $product = $this->repository->findProductByName('Non-existent Product', 'en_US');
            expect($product)->toBeNull();
        });
    });

    describe('SKU Management', function () {
        test('gets all available SKUs', function () {
            $skus = $this->repository->getAllSkus();

            expect($skus)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($skus as $sku) {
                expect($sku)->toBeString()->not->toBeEmpty();
            }

            expect($skus)->toContain('PHONE-001');
            expect($skus)->toContain('LAPTOP-001');
        });

        test('SKUs are consistent across locales', function () {
            $englishProducts = $this->repository->getAllProducts('en_US');
            $germanProducts = $this->repository->getAllProducts('de_DE');

            $englishSkus = array_column($englishProducts, 'sku');
            $germanSkus = array_column($germanProducts, 'sku');

            sort($englishSkus);
            sort($germanSkus);

            expect($englishSkus)->toEqual($germanSkus);
        });
    });

    describe('Product Names', function () {
        test('gets all product names for locale', function () {
            $names = $this->repository->getAllProductNames('en_US');

            expect($names)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($names as $name) {
                expect($name)->toBeString()->not->toBeEmpty();
            }

            expect($names)->toContain('Samsung Galaxy S24 Ultra 5G');
        });

        test('gets different names for different locales', function () {
            $englishNames = $this->repository->getAllProductNames('en_US');
            $germanNames = $this->repository->getAllProductNames('de_DE');

            expect($englishNames)->toContain('Samsung Galaxy S24 Ultra 5G');
            expect($germanNames)->toContain('Samsung Galaxy S24 Ultra');
            expect($englishNames)->not->toContain('Samsung Galaxy S24 Ultra');
            expect($germanNames)->not->toContain('Samsung Galaxy S24 Ultra 5G');
        });
    });

    describe('Locale Support', function () {
        test('gets supported locales', function () {
            $locales = $this->repository->getSupportedLocales();

            expect($locales)
                ->toBeArray()
                ->toContain('en_US')
                ->toContain('de_DE');
        });

        test('checks if product exists in locale', function () {
            expect($this->repository->hasProductInLocale('PHONE-001', 'en_US'))->toBeTrue();
            expect($this->repository->hasProductInLocale('PHONE-001', 'de_DE'))->toBeTrue();
            expect($this->repository->hasProductInLocale('PHONE-001', 'fr_FR'))->toBeFalse();
            expect($this->repository->hasProductInLocale('NON-EXISTENT', 'en_US'))->toBeFalse();
        });

        test('gets product locales', function () {
            $locales = $this->repository->getProductLocales('PHONE-001');

            expect($locales)
                ->toBeArray()
                ->toContain('en_US')
                ->toContain('de_DE');
        });

        test('returns empty array for non-existent product locales', function () {
            $locales = $this->repository->getProductLocales('NON-EXISTENT');
            expect($locales)->toBeArray()->toBeEmpty();
        });
    });

    describe('Category Groups', function () {
        test('gets all category groups', function () {
            $groups = $this->repository->getAllCategoryGroups();

            expect($groups)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($groups as $group) {
                expect($group)->toBeString()->not->toBeEmpty();
            }

            expect($groups)->toContain('electronics');
            expect($groups)->toContain('fashion');
        });

        test('gets products by category group', function () {
            $electronicsProducts = $this->repository->getProductsByCategoryGroup('electronics', 'en_US');

            expect($electronicsProducts)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($electronicsProducts as $product) {
                expect($product['category_group'])->toBe('electronics');
                expect($product)->toHaveKeys(['sku', 'name', 'description', 'category', 'category_group']);
                // Verify category is resolved
                expect($product['category'])->toBeString()->not->toBeEmpty();
            }
        });

        test('returns empty array for non-existent category group', function () {
            $products = $this->repository->getProductsByCategoryGroup('non-existent', 'en_US');
            expect($products)->toBeArray()->toBeEmpty();
        });
    });

    describe('Category Integration', function () {
        test('resolves category names from category keys', function () {
            $product = $this->repository->getProductBySku('PHONE-001', 'en_US');

            expect($product['category'])
                ->toBe('Cell Phones & Smartphones')
                ->not->toBe('cell-phones-smartphones'); // Should be resolved, not the key
        });

        test('resolves category names in different locales', function () {
            $englishProduct = $this->repository->getProductBySku('PHONE-001', 'en_US');
            $germanProduct = $this->repository->getProductBySku('PHONE-001', 'de_DE');

            expect($englishProduct['category'])->toBe('Cell Phones & Smartphones');
            expect($germanProduct['category'])->toBe('Smartphones & Handys');
        });

        test('provides access to CategoryRepository', function () {
            $categoryRepo = $this->repository->getCategoryRepository();

            expect($categoryRepo)->toBeInstanceOf(CategoryRepository::class);

            $categoryName = $categoryRepo->getCategoryName('electronics', 'en_US');
            expect($categoryName)->toBe('Electronics');
        });

        test('provides category methods through ProductRepository', function () {
            $categoryName = $this->repository->getCategoryName('electronics', 'en_US');
            expect($categoryName)->toBe('Electronics');

            $germanCategoryName = $this->repository->getCategoryName('electronics', 'de_DE');
            expect($germanCategoryName)->toBe('Computer & Zubehör');

            $allCategories = $this->repository->getAllCategories('en_US');
            expect($allCategories)->toBeArray()->not->toBeEmpty();

            $categoryKeys = $this->repository->getAllCategoryKeys();
            expect($categoryKeys)->toBeArray()->toContain('electronics');
        });
    });

    describe('Random Product', function () {
        test('gets random product', function () {
            $product = $this->repository->getRandomProduct('en_US');

            expect($product)
                ->not->toBeNull()
                ->toHaveKeys(['sku', 'name', 'description', 'category', 'category_group']);

            // Verify category is resolved
            expect($product['category'])->toBeString()->not->toBeEmpty();
            expect($product['category'])->not->toMatch('/^[a-z-]+$/', 'Category should be resolved name, not key');
        });

        test('returns null for unsupported locale', function () {
            $product = $this->repository->getRandomProduct('fr_FR');
            expect($product)->toBeNull();
        });
    });

    describe('Error Handling', function () {
        test('handles invalid locale gracefully', function () {
            $products = $this->repository->getAllProducts('invalid_locale');
            expect($products)->toBeArray()->toBeEmpty();
        });

        test('handles missing category gracefully', function () {
            // This would require creating a product with an invalid category key
            // For now, we test that existing products work correctly
            $product = $this->repository->getProductBySku('PHONE-001', 'en_US');
            expect($product['category'])->toBeString()->not->toBeEmpty();
        });
    });

    describe('Caching Behavior', function () {
        test('caches products after first load', function () {
            // First call should load from files
            $products1 = $this->repository->getAllProducts('en_US');

            // Second call should use cache
            $products2 = $this->repository->getAllProducts('en_US');

            expect($products1)->toEqual($products2);
        });

        test('cache can be cleared', function () {
            // Load products to populate cache
            $this->repository->getAllProducts('en_US');

            // Clear cache
            ProductRepository::clearCache();

            // Should still work after cache clear
            $products = $this->repository->getAllProducts('en_US');
            expect($products)->toBeArray()->not->toBeEmpty();
        });
    });

    describe('Data Validation', function () {
        test('all products have required fields', function () {
            $products = $this->repository->getAllProducts('en_US');

            foreach ($products as $product) {
                expect($product)
                    ->toHaveKeys(['sku', 'category_group', 'name', 'description', 'category'])
                    ->and($product['sku'])->toBeString()->not->toBeEmpty()
                    ->and($product['name'])->toBeString()->not->toBeEmpty()
                    ->and($product['description'])->toBeString()->not->toBeEmpty()
                    ->and($product['category'])->toBeString()->not->toBeEmpty()
                    ->and($product['category_group'])->toBeString()->not->toBeEmpty();
            }
        });

        test('SKUs follow naming convention', function () {
            $skus = $this->repository->getAllSkus();

            foreach ($skus as $sku) {
                // SKUs should be uppercase with hyphens
                expect($sku)->toMatch('/^[A-Z0-9-]+$/', "SKU '{$sku}' should only contain uppercase letters, numbers, and hyphens");
                expect($sku)->not->toStartWith('-');
                expect($sku)->not->toEndWith('-');
            }
        });

        test('no duplicate SKUs', function () {
            $skus = $this->repository->getAllSkus();
            $uniqueSkus = array_unique($skus);

            expect(count($skus))->toBe(count($uniqueSkus), 'All SKUs should be unique');
        });

        test('category groups are valid', function () {
            $groups = $this->repository->getAllCategoryGroups();

            foreach ($groups as $group) {
                expect($group)->toBeString()->not->toBeEmpty();
                // Category groups should be lowercase
                expect($group)->toMatch('/^[a-z]+$/', "Category group '{$group}' should be lowercase letters only");
            }
        });
    });
});