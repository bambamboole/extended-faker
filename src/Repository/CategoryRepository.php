<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

class CategoryRepository extends JsonFileRepository
{
    public function __construct()
    {
        parent::__construct('categories', 'key');
    }

    public function getCategoryByKey(string $key, string $locale = 'en_US'): ?array
    {
        $category = $this->getItemByKey($key);
        if (!$category || !isset($category['locales'][$locale])) {
            return null;
        }
        return array_merge(['key' => $key, 'parent' => $category['parent'] ?? null], $category['locales'][$locale]);
    }

    public function getCategoryName(string $key, string $locale = 'en_US'): ?string
    {
        $category = $this->getCategoryByKey($key, $locale);
        return $category['name'] ?? null;
    }

    public function getAllCategories(string $locale = 'en_US'): array
    {
        $result = [];
        foreach ($this->getItems() as $key => $category) {
            if (isset($category['locales'][$locale])) {
                $result[] = array_merge([
                    'key' => $key,
                    'parent' => $category['parent'] ?? null,
                ], $category['locales'][$locale]);
            }
        }
        return $result;
    }

    public function getAllCategoryKeys(): array
    {
        return $this->getAllKeys();
    }

    public function getAllCategoryNames(string $locale = 'en_US'): array
    {
        $names = [];
        foreach ($this->getItems() as $category) {
            if (isset($category['locales'][$locale])) {
                $names[] = $category['locales'][$locale]['name'];
            }
        }
        return $names;
    }

    public function hasCategoryInLocale(string $key, string $locale): bool
    {
        return $this->hasItemInLocale($key, $locale);
    }

    public function getCategoryLocales(string $key): array
    {
        return $this->getItemLocales($key);
    }

    public function getCategoriesByParent(?string $parent, string $locale = 'en_US'): array
    {
        $result = [];
        foreach ($this->getItems() as $key => $category) {
            if (($category['parent'] ?? null) === $parent && isset($category['locales'][$locale])) {
                $result[] = array_merge([
                    'key' => $key,
                    'parent' => $category['parent'] ?? null,
                ], $category['locales'][$locale]);
            }
        }
        return $result;
    }

    public function getRootCategories(string $locale = 'en_US'): array
    {
        return $this->getCategoriesByParent(null, $locale);
    }

    public function getChildCategories(string $parentKey, string $locale = 'en_US'): array
    {
        return $this->getCategoriesByParent($parentKey, $locale);
    }

    public function hasChildren(string $key): bool
    {
        foreach ($this->getItems() as $category) {
            if (($category['parent'] ?? null) === $key) {
                return true;
            }
        }
        return false;
    }
}
