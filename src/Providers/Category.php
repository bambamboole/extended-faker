<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Faker\Provider\Base;

class Category extends Base
{
    protected CategoryRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new CategoryRepository();
    }

    private function findCategory(?string $identifier): ?array
    {
        if ($identifier === null) {
            $categories = $this->repository->getAllCategories($this->getLocale());
            return empty($categories) ? null : $this->randomElement($categories);
        }

        $category = $this->repository->getCategoryByKey($identifier, $this->getLocale());
        if ($category) return $category;

        foreach ($this->repository->getAllCategories($this->getLocale()) as $cat) {
            if ($cat['name'] === $identifier) return $cat;
        }
        return null;
    }

    public function categoryName(?string $identifier = null): string
    {
        $category = $this->findCategory($identifier);
        if (!$category) {
            if ($identifier === null) return 'General';
            throw new \InvalidArgumentException("Category '{$identifier}' not found in available categories.");
        }
        return $category['name'];
    }

    public function category(?string $identifier = null): array
    {
        $category = $this->findCategory($identifier);
        if (!$category) {
            if ($identifier === null) return ['key' => 'general', 'name' => 'General', 'parent' => null];
            throw new \InvalidArgumentException("Category '{$identifier}' not found in available categories.");
        }
        return $category;
    }

    public function categoryByKey(string $key, ?string $locale = null): array
    {
        $locale ??= $this->getLocale();
        $category = $this->repository->getCategoryByKey($key, $locale);
        if (!$category) throw new \InvalidArgumentException("Category with key '{$key}' not found in locale '{$locale}'.");
        return $category;
    }

    public function getAvailableCategoryNames(): array
    {
        return $this->repository->getAllCategoryNames($this->getLocale());
    }

    public function getAvailableCategoryKeys(): array
    {
        return $this->repository->getAllCategoryKeys();
    }

    public function getSupportedLocales(): array
    {
        return $this->repository->getSupportedLocales();
    }

    public function hasCategoryInLocale(string $key, ?string $locale = null): bool
    {
        return $this->repository->hasCategoryInLocale($key, $locale ?? $this->getLocale());
    }

    public function getCategoriesByParent(?string $parent = null): array
    {
        return $this->repository->getCategoriesByParent($parent, $this->getLocale());
    }

    public function getRootCategories(): array
    {
        return $this->repository->getRootCategories($this->getLocale());
    }

    public function getChildCategories(string $parentKey): array
    {
        return $this->repository->getChildCategories($parentKey, $this->getLocale());
    }

    public function hasChildren(string $key): bool
    {
        return $this->repository->hasChildren($key);
    }

    public function randomRootCategory(): array
    {
        $categories = $this->getRootCategories();
        return empty($categories) ? ['key' => 'general', 'name' => 'General', 'parent' => null] : $this->randomElement($categories);
    }

    public function randomChildCategory(string $parentKey): ?array
    {
        $children = $this->getChildCategories($parentKey);
        return empty($children) ? null : $this->randomElement($children);
    }

    public function getCategoryLocales(string $key): array
    {
        return $this->repository->getCategoryLocales($key);
    }

    protected function getLocale(): string
    {
        $locale = property_exists($this->generator, 'locale') ? $this->generator->locale ?? 'en_US' : 'en_US';
        if (str_starts_with($locale, 'en')) return 'en_US';
        if (str_starts_with($locale, 'de')) return 'de_DE';
        return 'en_US';
    }
}