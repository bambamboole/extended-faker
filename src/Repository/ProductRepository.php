<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Generator\ProductGenerator;
use Bambamboole\ExtendedFaker\Generator\ProductSku;
use Bambamboole\ExtendedFaker\Generator\ProductTemplates;

class ProductRepository
{
    private const SEED_MAX = 2147483647;

    public function __construct(
        private readonly ProductGenerator $generator = new ProductGenerator,
        private readonly ProductTemplates $templates = new ProductTemplates,
        private readonly CategoryRepository $categoryRepository = new CategoryRepository,
    ) {}

    public function generate(int $seed, ?string $category = null, string $locale = 'en_US'): ProductDto
    {
        return $this->generator->generate($seed, $category, $locale);
    }

    public function getProductBySku(string $sku, string $locale = 'en_US'): ?ProductDto
    {
        $decoded = ProductSku::decode($sku);
        if ($decoded === null) {
            return null;
        }

        // Validate the prefix is known before generating.
        $category = $this->templates->categoryForPrefix($decoded['prefix']);
        if ($category === null) {
            return null;
        }

        return $this->generator->generate($decoded['seed'], $category, $locale);
    }

    public function getRandomProduct(string $locale = 'en_US'): ProductDto
    {
        return $this->generator->generate(random_int(0, self::SEED_MAX), null, $locale);
    }

    /** @return list<ProductDto> */
    public function getAllProducts(string $locale = 'en_US', int $count = 50): array
    {
        $products = [];
        for ($seed = 0; $seed < $count; $seed++) {
            $products[] = $this->generator->generate($seed, null, $locale);
        }

        return $products;
    }

    /** @return list<ProductDto> */
    public function getProductsByCategory(string $category, string $locale = 'en_US', int $count = 25): array
    {
        $products = [];
        for ($seed = 0; $seed < $count; $seed++) {
            $products[] = $this->generator->generate($seed, $category, $locale);
        }

        return $products;
    }

    public function getCategoryRepository(): CategoryRepository
    {
        return $this->categoryRepository;
    }

    public function getCategoryName(string $key, string $locale = 'en_US'): ?string
    {
        return $this->categoryRepository->getCategoryName($key, $locale);
    }

    /** @return list<string> */
    public function getUsedCategories(): array
    {
        return $this->templates->categories();
    }
}
