<?php declare(strict_types=1);
namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Dto\ProductDto;

class ProductRepository extends JsonFileRepository
{
    private readonly CategoryRepository $categoryRepository;

    public function __construct(?CategoryRepository $categoryRepository = null)
    {
        parent::__construct('products', 'sku');
        $this->categoryRepository = $categoryRepository ?? new CategoryRepository();
    }

    private function resolveProduct(string $sku, array $product, string $locale): ProductDto
    {
        $productData = $product['locales'][$locale];
        $categoryName =
            $this->categoryRepository->getCategoryName($product['category'], $locale) ?? $product['category'];
        return new ProductDto($sku, $productData['name'], $productData['description'], $categoryName);
    }

    public function getProductBySku(string $sku, string $locale = 'en_US'): ?ProductDto
    {
        $expandedItems = $this->getExpandedItems();
        $product = $expandedItems[$sku] ?? null;
        if (!$product || !isset($product['locales'][$locale])) {
            return null;
        }
        return $this->resolveProduct($sku, $product, $locale);
    }

    public function findProductByName(string $name, string $locale = 'en_US'): ?ProductDto
    {
        foreach ($this->getExpandedItems() as $sku => $product) {
            if (isset($product['locales'][$locale]) && $product['locales'][$locale]['name'] === $name) {
                return $this->resolveProduct($sku, $product, $locale);
            }
        }
        return null;
    }

    public function getAllProducts(string $locale = 'en_US'): array
    {
        $result = [];
        foreach ($this->getExpandedItems() as $sku => $product) {
            if (isset($product['locales'][$locale])) {
                $result[] = $this->resolveProduct($sku, $product, $locale);
            }
        }
        return $result;
    }

    public function getAllSkus(): array
    {
        return array_keys($this->getExpandedItems());
    }

    public function getAllProductNames(string $locale = 'en_US'): array
    {
        $names = [];
        foreach ($this->getExpandedItems() as $product) {
            if (isset($product['locales'][$locale])) {
                $names[] = $product['locales'][$locale]['name'];
            }
        }
        return $names;
    }

    public function hasProductInLocale(string $sku, string $locale): bool
    {
        $expandedItems = $this->getExpandedItems();
        $product = $expandedItems[$sku] ?? null;
        return $product && isset($product['locales'][$locale]);
    }

    public function getItemLocales(string $sku): array
    {
        $expandedItems = $this->getExpandedItems();
        $product = $expandedItems[$sku] ?? null;
        return $product && isset($product['locales']) ? array_keys($product['locales']) : [];
    }

    public function getRandomProduct(string $locale = 'en_US'): ?ProductDto
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

    private function hasVariants(array $product): bool
    {
        return isset($product['variants']) && is_array($product['variants']) && !empty($product['variants']);
    }

    private function generateVariantCombinations(array $variants): array
    {
        $combinations = [[]];

        foreach ($variants as $variantName => $variantValues) {
            $newCombinations = [];
            foreach ($combinations as $combination) {
                foreach ($variantValues as $value) {
                    $newCombination = $combination;
                    $newCombination[$variantName] = $value;
                    $newCombinations[] = $newCombination;
                }
            }
            $combinations = $newCombinations;
        }

        return $combinations;
    }

    private function generateVariantSku(string $baseSku, array $variantCombination): string
    {
        $skuParts = [$baseSku];

        foreach ($variantCombination as $variantName => $variantValue) {
            $sanitized = strtoupper(str_replace([' ', '.'], ['', ''], $variantValue));
            $skuParts[] = $sanitized;
        }

        return implode('-', $skuParts);
    }

    private function interpolateTemplate(string $template, array $variantCombination): string
    {
        $result = $template;
        foreach ($variantCombination as $variantName => $variantValue) {
            $result = str_replace('{' . $variantName . '}', $variantValue, $result);
        }
        return $result;
    }

    private function expandProductVariants(string $baseSku, array $product): array
    {
        if (!$this->hasVariants($product)) {
            return [$baseSku => $product];
        }

        $expandedProducts = [];
        $combinations = $this->generateVariantCombinations($product['variants']);

        foreach ($combinations as $combination) {
            $variantSku = $this->generateVariantSku($baseSku, $combination);
            $variantProduct = $product;

            unset($variantProduct['variants']);

            foreach ($variantProduct['locales'] as $locale => &$localeData) {
                if (isset($localeData['name'])) {
                    $localeData['name'] = $this->interpolateTemplate($localeData['name'], $combination);
                }
                if (isset($localeData['description'])) {
                    $localeData['description'] = $this->interpolateTemplate($localeData['description'], $combination);
                }
            }

            $expandedProducts[$variantSku] = $variantProduct;
        }

        return $expandedProducts;
    }

    protected function getExpandedItems(): array
    {
        $cacheKey = static::class . '_expanded';
        if (isset(self::$caches[$cacheKey])) {
            return self::$caches[$cacheKey];
        }

        $baseItems = $this->getItems();
        $expandedItems = [];

        foreach ($baseItems as $baseSku => $product) {
            $variants = $this->expandProductVariants($baseSku, $product);
            $expandedItems = array_merge($expandedItems, $variants);
        }

        self::$caches[$cacheKey] = $expandedItems;
        return $expandedItems;
    }
}
