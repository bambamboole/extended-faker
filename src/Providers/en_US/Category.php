<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\en_US;

use Bambamboole\ExtendedFaker\Providers\Category as BaseCategory;

class Category extends BaseCategory
{
    protected function getLocale(): string
    {
        return 'en_US';
    }

    public function usCategories(): array
    {
        $keys = ['electronics', 'cell-phones-smartphones', 'computers-accessories', 'home-garden', 'kitchen-dining', 'athletic-apparel', 'sports-outdoors', 'automotive'];
        $result = [];
        foreach ($this->repository->getAllCategories('en_US') as $category) {
            if (in_array($category['key'], $keys)) $result[] = $category;
        }
        return $result;
    }

    public function randomUsCategory(): array
    {
        $categories = $this->usCategories();
        return empty($categories) ? $this->category() : $this->randomElement($categories);
    }

    public function technologyCategories(): array
    {
        $result = [];
        foreach (['electronics', 'cell-phones-smartphones', 'computers-accessories', 'wearable-technology'] as $key) {
            $category = $this->repository->getCategoryByKey($key, 'en_US');
            if ($category) $result[] = $category;
        }
        return $result;
    }

    public function randomTechnologyCategory(): array
    {
        $categories = $this->technologyCategories();
        return empty($categories) ? $this->category() : $this->randomElement($categories);
    }
}