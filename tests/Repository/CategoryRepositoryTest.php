<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

beforeEach(function () {
    $this->repository = new CategoryRepository();
    CategoryRepository::clearCache();
});

afterEach(function () {
    CategoryRepository::clearCache();
});

test('loads categories from JSON files', function () {
    $categories = $this->repository->getAllCategories('en_US');
    expect($categories)->toBeArray()->not->toBeEmpty();
    expect($categories[0])->toHaveKeys(['key', 'name', 'parent']);
});

test('gets category by key', function () {
    $category = $this->repository->getCategoryByKey('cell-phones-smartphones', 'en_US');
    expect($category)->not->toBeNull()->toHaveKey('key', 'cell-phones-smartphones');

    expect($this->repository->getCategoryByKey('NON-EXISTENT', 'en_US'))->toBeNull();
});

test('gets category names', function () {
    expect($this->repository->getCategoryName('cell-phones-smartphones', 'en_US'))->toBe('Cell Phones & Smartphones');
    expect($this->repository->getAllCategoryNames('en_US'))->toBeArray()->not->toBeEmpty();
    expect($this->repository->getAllCategoryKeys())->toBeArray()->not->toBeEmpty();
});

test('checks locale support', function () {
    expect($this->repository->getSupportedLocales())->toContain('en_US', 'de_DE');
    expect($this->repository->hasCategoryInLocale('cell-phones-smartphones', 'en_US'))->toBeTrue();
    expect($this->repository->getCategoryLocales('cell-phones-smartphones'))->toBeArray()->not->toBeEmpty();
});

test('handles hierarchy', function () {
    $rootCategories = $this->repository->getRootCategories('en_US');
    $categoriesByParent = $this->repository->getCategoriesByParent(null, 'en_US');

    expect($rootCategories)->toBeArray();
    expect($categoriesByParent)->toBeArray();
});

test('caches categories', function () {
    $categories1 = $this->repository->getAllCategories('en_US');
    $categories2 = $this->repository->getAllCategories('en_US');
    expect($categories1)->toBe($categories2);
});
