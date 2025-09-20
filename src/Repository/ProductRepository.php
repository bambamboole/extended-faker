<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

class ProductRepository extends JsonFileRepository
{
    private readonly CategoryRepository $categoryRepository;

    public function __construct(?CategoryRepository $categoryRepository = null)
    {
        parent::__construct('products', 'sku');
        $this->categoryRepository = $categoryRepository ?? new CategoryRepository();
    }

    private function resolveProduct(string $sku, array $product, string $locale): array
    {
        $productData = $product['locales'][$locale];
        $categoryName =
            $this->categoryRepository->getCategoryName($product['category'], $locale) ?? $product['category'];
        return array_merge(['sku' => $sku], $productData, ['category' => $categoryName]);
    }

    public function getProductBySku(string $sku, string $locale = 'en_US'): ?array
    {
        $product = $this->getItemByKey($sku);
        if (!$product || !isset($product['locales'][$locale])) {
            return null;
        }
        return $this->resolveProduct($sku, $product, $locale);
    }

    public function findProductByName(string $name, string $locale = 'en_US'): ?array
    {
        foreach ($this->getItems() as $sku => $product) {
            if (isset($product['locales'][$locale]) && $product['locales'][$locale]['name'] === $name) {
                return $this->resolveProduct($sku, $product, $locale);
            }
        }
        return null;
    }

    public function getAllProducts(string $locale = 'en_US'): array
    {
        $result = [];
        foreach ($this->getItems() as $sku => $product) {
            if (isset($product['locales'][$locale])) {
                $result[] = $this->resolveProduct($sku, $product, $locale);
            }
        }
        return $result;
    }

    public function getAllSkus(): array
    {
        return $this->getAllKeys();
    }

    public function getAllProductNames(string $locale = 'en_US'): array
    {
        $names = [];
        foreach ($this->getItems() as $product) {
            if (isset($product['locales'][$locale])) {
                $names[] = $product['locales'][$locale]['name'];
            }
        }
        return $names;
    }

    public function hasProductInLocale(string $sku, string $locale): bool
    {
        return $this->hasItemInLocale($sku, $locale);
    }

    public function getRandomProduct(string $locale = 'en_US'): ?array
    {
        $products = $this->getAllProducts($locale);
        return empty($products) ? null : $products[array_rand($products)];
    }

    public function getProductsByCategory(string $category, string $locale = 'en_US'): array
    {
        $result = [];
        foreach ($this->getItems() as $sku => $product) {
            if ($product['category'] === $category && isset($product['locales'][$locale])) {
                $result[] = $this->resolveProduct($sku, $product, $locale);
            }
        }
        return $result;
    }

    public function getUsedCategories(): array
    {
        $categories = [];
        foreach ($this->getItems() as $product) {
            $categories[] = $product['category'];
        }
        return array_unique($categories);
    }

    public function getCategoryRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

    public function getCategoryName(string $key, string $locale = 'en_US'): ?string
    {
        return $this->categoryRepository->getCategoryName($key, $locale);
    }

    public function getAllCategories(string $locale = 'en_US'): array
    {
        return $this->categoryRepository->getAllCategories($locale);
    }

    public function getAllCategoryKeys(): array
    {
        return $this->categoryRepository->getAllCategoryKeys();
    }
}
