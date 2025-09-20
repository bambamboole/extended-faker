<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Faker\Provider\Base;

abstract class Category extends Base
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
        if ($category) {
            return $category;
        }

        foreach ($this->repository->getAllCategories($this->getLocale()) as $cat) {
            if ($cat['name'] === $identifier) {
                return $cat;
            }
        }
        return null;
    }

    public function categoryName(?string $identifier = null): string
    {
        $category = $this->findCategory($identifier);
        if (!$category) {
            if ($identifier === null) {
                return 'General';
            }
            throw new \InvalidArgumentException("Category '{$identifier}' not found in available categories.");
        }
        return $category['name'];
    }

    public function category(?string $identifier = null): array
    {
        $category = $this->findCategory($identifier);
        if (!$category) {
            if ($identifier === null) {
                return ['key' => 'general', 'name' => 'General', 'parent' => null];
            }
            throw new \InvalidArgumentException("Category '{$identifier}' not found in available categories.");
        }
        return $category;
    }

    abstract protected function getLocale(): string;
}
