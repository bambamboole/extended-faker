<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;

beforeEach(function () {
    $this->repository = new ProductRepository();
    ProductRepository::clearCache();
    CategoryRepository::clearCache();
});

afterEach(function () {
    ProductRepository::clearCache();
    CategoryRepository::clearCache();
});

test('loads products from JSON files', function () {
    $products = $this->repository->getAllProducts('en_US');
    expect($products)->toBeArray()->not->toBeEmpty();
    expect($products[0])->toHaveKeys(['sku', 'name', 'description', 'category']);
});

test('gets product by SKU', function () {
    $product = $this->repository->getProductBySku('PHONE-001', 'en_US');
    expect($product)->not->toBeNull()->toHaveKey('sku', 'PHONE-001');

    expect($this->repository->getProductBySku('NON-EXISTENT', 'en_US'))->toBeNull();
});

test('finds product by name', function () {
    $skus = $this->repository->getAllSkus();
    $firstProduct = $this->repository->getProductBySku($skus[0], 'en_US');
    $foundProduct = $this->repository->findProductByName($firstProduct['name'], 'en_US');

    expect($foundProduct['sku'])->toBe($firstProduct['sku']);
});

test('gets product names and SKUs', function () {
    expect($this->repository->getAllSkus())->toBeArray()->not->toBeEmpty();
    expect($this->repository->getAllProductNames('en_US'))->toBeArray()->not->toBeEmpty();
});

test('checks locale support', function () {
    expect($this->repository->getSupportedLocales())->toContain('en_US', 'de_DE');
    expect($this->repository->hasProductInLocale('PHONE-001', 'en_US'))->toBeTrue();
    expect($this->repository->getItemLocales('PHONE-001'))->toBeArray()->not->toBeEmpty();
});

test('gets products by category', function () {
    $categories = $this->repository->getUsedCategories();
    $products = $this->repository->getProductsByCategory($categories[0], 'en_US');
    expect($products)->toBeArray();
});

test('resolves category names', function () {
    $product = $this->repository->getProductBySku('PHONE-001', 'en_US');
    expect($product['category'])->toBeString()->not->toBeEmpty();
});

test('provides category repository access', function () {
    expect($this->repository->getCategoryRepository())->toBeInstanceOf(CategoryRepository::class);
});

test('gets random product', function () {
    $product = $this->repository->getRandomProduct('en_US');
    expect($product)->toBeArray()->toHaveKey('sku');
});

test('caches products', function () {
    $products1 = $this->repository->getAllProducts('en_US');
    $products2 = $this->repository->getAllProducts('en_US');
    expect($products1)->toBe($products2);
});
