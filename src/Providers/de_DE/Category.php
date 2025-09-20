<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers\de_DE;

use Bambamboole\ExtendedFaker\Providers\Category as BaseCategory;

class Category extends BaseCategory
{
    protected function getLocale(): string
    {
        return 'de_DE';
    }

    public function deutscheKategorien(): array
    {
        $keys = ['electronics', 'cell-phones-smartphones', 'computers-accessories', 'kitchen-dining', 'furniture', 'sports-outdoors', 'beauty', 'automotive'];
        $result = [];
        foreach ($this->repository->getAllCategories('de_DE') as $category) {
            if (in_array($category['key'], $keys)) $result[] = $category;
        }
        return $result;
    }

    public function zufälligeDeutscheKategorie(): array
    {
        $categories = $this->deutscheKategorien();
        return empty($categories) ? $this->category() : $this->randomElement($categories);
    }

    public function technikKategorien(): array
    {
        $result = [];
        foreach (['electronics', 'cell-phones-smartphones', 'computers-accessories', 'wearable-technology'] as $key) {
            $category = $this->repository->getCategoryByKey($key, 'de_DE');
            if ($category) $result[] = $category;
        }
        return $result;
    }

    public function zufälligeTechnikKategorie(): array
    {
        $categories = $this->technikKategorien();
        return empty($categories) ? $this->category() : $this->randomElement($categories);
    }

    public function haushaltKategorien(): array
    {
        $result = [];
        foreach (['kitchen-dining', 'furniture', 'home-garden'] as $key) {
            $category = $this->repository->getCategoryByKey($key, 'de_DE');
            if ($category) $result[] = $category;
        }
        return $result;
    }

    public function zufälligeHaushaltKategorie(): array
    {
        $categories = $this->haushaltKategorien();
        return empty($categories) ? $this->category() : $this->randomElement($categories);
    }
}