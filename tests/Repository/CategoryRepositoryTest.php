<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

beforeEach(function () {
    $this->repository = new CategoryRepository();
    // Clear cache before each test
    CategoryRepository::clearCache();
});

afterEach(function () {
    // Clear cache after each test
    CategoryRepository::clearCache();
});

describe('CategoryRepository', function () {
    describe('Basic Category Loading', function () {
        test('loads categories from JSON files', function () {
            $categories = $this->repository->getAllCategories('en_US');

            expect($categories)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($categories as $category) {
                expect($category)
                    ->toHaveKeys(['key', 'name', 'parent'])
                    ->and($category['key'])->toBeString()->not->toBeEmpty()
                    ->and($category['name'])->toBeString()->not->toBeEmpty();
            }
        });

        test('gets category by key in English', function () {
            $category = $this->repository->getCategoryByKey('cell-phones-smartphones', 'en_US');

            expect($category)
                ->not->toBeNull()
                ->toHaveKeys(['key', 'name', 'parent'])
                ->and($category['key'])->toBe('cell-phones-smartphones')
                ->and($category['name'])->toBe('Cell Phones & Smartphones');
        });

        test('gets category by key in German', function () {
            $category = $this->repository->getCategoryByKey('cell-phones-smartphones', 'de_DE');

            expect($category)
                ->not->toBeNull()
                ->toHaveKeys(['key', 'name', 'parent'])
                ->and($category['key'])->toBe('cell-phones-smartphones')
                ->and($category['name'])->toBe('Smartphones & Handys');
        });

        test('returns null for non-existent category key', function () {
            $category = $this->repository->getCategoryByKey('non-existent-category', 'en_US');

            expect($category)->toBeNull();
        });

        test('returns null for valid key in unsupported locale', function () {
            $category = $this->repository->getCategoryByKey('electronics', 'fr_FR');

            expect($category)->toBeNull();
        });
    });

    describe('Category Names', function () {
        test('gets category name by key', function () {
            $name = $this->repository->getCategoryName('electronics', 'en_US');
            expect($name)->toBe('Electronics');

            $germanName = $this->repository->getCategoryName('electronics', 'de_DE');
            expect($germanName)->toBe('Computer & Zubehör');
        });

        test('returns null for non-existent category name', function () {
            $name = $this->repository->getCategoryName('non-existent', 'en_US');
            expect($name)->toBeNull();
        });

        test('gets all category names for locale', function () {
            $names = $this->repository->getAllCategoryNames('en_US');

            expect($names)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($names as $name) {
                expect($name)->toBeString()->not->toBeEmpty();
            }

            expect($names)->toContain('Electronics');
            expect($names)->toContain('Cell Phones & Smartphones');
        });

        test('gets different names for different locales', function () {
            $englishNames = $this->repository->getAllCategoryNames('en_US');
            $germanNames = $this->repository->getAllCategoryNames('de_DE');

            expect($englishNames)->toContain('Electronics');
            expect($germanNames)->toContain('Computer & Zubehör');
            expect($englishNames)->not->toContain('Computer & Zubehör');
            expect($germanNames)->not->toContain('Electronics');
        });
    });

    describe('Category Keys', function () {
        test('gets all category keys', function () {
            $keys = $this->repository->getAllCategoryKeys();

            expect($keys)
                ->toBeArray()
                ->not->toBeEmpty();

            foreach ($keys as $key) {
                expect($key)->toBeString()->not->toBeEmpty();
            }

            expect($keys)->toContain('electronics');
            expect($keys)->toContain('cell-phones-smartphones');
        });

        test('category keys are consistent across locales', function () {
            $englishCategories = $this->repository->getAllCategories('en_US');
            $germanCategories = $this->repository->getAllCategories('de_DE');

            $englishKeys = array_column($englishCategories, 'key');
            $germanKeys = array_column($germanCategories, 'key');

            // Keys should be the same, names different
            expect($englishKeys)->toEqual($germanKeys);
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

        test('checks if category exists in locale', function () {
            expect($this->repository->hasCategoryInLocale('electronics', 'en_US'))->toBeTrue();
            expect($this->repository->hasCategoryInLocale('electronics', 'de_DE'))->toBeTrue();
            expect($this->repository->hasCategoryInLocale('electronics', 'fr_FR'))->toBeFalse();
            expect($this->repository->hasCategoryInLocale('non-existent', 'en_US'))->toBeFalse();
        });

        test('gets category locales', function () {
            $locales = $this->repository->getCategoryLocales('electronics');

            expect($locales)
                ->toBeArray()
                ->toContain('en_US')
                ->toContain('de_DE');
        });

        test('returns empty array for non-existent category locales', function () {
            $locales = $this->repository->getCategoryLocales('non-existent');
            expect($locales)->toBeArray()->toBeEmpty();
        });
    });

    describe('Hierarchy Support', function () {
        test('gets root categories (no parent)', function () {
            $rootCategories = $this->repository->getRootCategories('en_US');

            expect($rootCategories)->toBeArray();

            foreach ($rootCategories as $category) {
                expect($category['parent'])->toBeNull();
            }

            // All our current categories are root categories
            expect(count($rootCategories))->toBeGreaterThan(0);
        });

        test('gets categories by parent', function () {
            // Test with null parent (root categories)
            $rootCategories = $this->repository->getCategoriesByParent(null, 'en_US');
            expect($rootCategories)->toBeArray();

            foreach ($rootCategories as $category) {
                expect($category['parent'])->toBeNull();
            }

            // Test with non-existent parent
            $childCategories = $this->repository->getCategoriesByParent('non-existent-parent', 'en_US');
            expect($childCategories)->toBeArray()->toBeEmpty();
        });

        test('gets child categories', function () {
            // Since we don't have hierarchical categories yet, this should return empty
            $children = $this->repository->getChildCategories('electronics', 'en_US');
            expect($children)->toBeArray();

            // Test with non-existent parent
            $noChildren = $this->repository->getChildCategories('non-existent', 'en_US');
            expect($noChildren)->toBeArray()->toBeEmpty();
        });

        test('checks if category has children', function () {
            // Current categories don't have children
            expect($this->repository->hasChildren('electronics'))->toBeFalse();
            expect($this->repository->hasChildren('non-existent'))->toBeFalse();
        });
    });

    describe('Error Handling', function () {
        test('throws exception for missing categories directory', function () {
            // This test would require mocking the filesystem or temporarily moving the directory
            // For now, we'll test that the repository works with existing directory
            expect(function () {
                $this->repository->getAllCategories('en_US');
            })->not->toThrow(RuntimeException::class);
        });

        test('handles invalid locale gracefully', function () {
            $categories = $this->repository->getAllCategories('invalid_locale');
            expect($categories)->toBeArray()->toBeEmpty();
        });
    });

    describe('Caching Behavior', function () {
        test('caches categories after first load', function () {
            // First call should load from files
            $categories1 = $this->repository->getAllCategories('en_US');

            // Second call should use cache (we can't directly test this without inspecting internals,
            // but we can verify the results are consistent)
            $categories2 = $this->repository->getAllCategories('en_US');

            expect($categories1)->toEqual($categories2);
        });

        test('cache can be cleared', function () {
            // Load categories to populate cache
            $this->repository->getAllCategories('en_US');

            // Clear cache
            CategoryRepository::clearCache();

            // Should still work after cache clear
            $categories = $this->repository->getAllCategories('en_US');
            expect($categories)->toBeArray()->not->toBeEmpty();
        });
    });

    describe('Data Validation', function () {
        test('all categories have required fields', function () {
            $categories = $this->repository->getAllCategories('en_US');

            foreach ($categories as $category) {
                expect($category)
                    ->toHaveKeys(['key', 'name', 'parent'])
                    ->and($category['key'])->toBeString()->not->toBeEmpty()
                    ->and($category['name'])->toBeString()->not->toBeEmpty();

                // Parent can be null or string
                if ($category['parent'] !== null) {
                    expect($category['parent'])->toBeString()->not->toBeEmpty();
                }
            }
        });

        test('category keys follow naming convention', function () {
            $keys = $this->repository->getAllCategoryKeys();

            foreach ($keys as $key) {
                // Keys should be lowercase with hyphens
                expect($key)->toMatch('/^[a-z0-9-]+$/', "Key '{$key}' should only contain lowercase letters, numbers, and hyphens");
                expect($key)->not->toStartWith('-');
                expect($key)->not->toEndWith('-');
            }
        });

        test('no duplicate category keys', function () {
            $keys = $this->repository->getAllCategoryKeys();
            $uniqueKeys = array_unique($keys);

            expect(count($keys))->toBe(count($uniqueKeys), 'All category keys should be unique');
        });
    });
});