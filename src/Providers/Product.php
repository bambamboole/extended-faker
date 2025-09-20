<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Faker\Provider\Base;

class Product extends Base
{
    /**
     * Structured product data with name-description-category mappings
     * (will be overridden by locale providers)
     */
    protected static $products = [
        [
            'name' => 'Generic Product',
            'description' => 'A high-quality product designed for everyday use.',
            'category' => 'Electronics',
        ],
        [
            'name' => 'Standard Item',
            'description' => 'Professional-grade item with excellent durability.',
            'category' => 'Clothing',
        ],
        [
            'name' => 'Basic Product',
            'description' => 'Essential product for modern lifestyle.',
            'category' => 'Home & Garden',
        ],
        [
            'name' => 'Essential Item',
            'description' => 'Reliable and efficient solution for your needs.',
            'category' => 'Books',
        ],
        [
            'name' => 'Universal Product',
            'description' => 'Premium quality item with outstanding performance.',
            'category' => 'Health',
        ],
    ];

    /**
     * Legacy arrays for backward compatibility
     * @deprecated Use $products instead
     */
    protected static $productNames = [];
    protected static $productDescriptions = [];
    protected static $productCategories = [];

    /**
     * Generate a random product name or get name for specific product.
     *
     * @param string|null $name If provided, validates the name exists
     * @return string
     *
     * @example productName() // 'Generic Product'
     * @example productName('Standard Item') // 'Standard Item'
     */
    public function productName(?string $name = null): string
    {
        if ($name !== null) {
            $product = $this->findProductByName($name);
            return $product['name'];
        }

        return static::randomElement(static::$products)['name'];
    }

    /**
     * Generate a random product description or get description for specific product.
     *
     * @param string|null $name If provided, returns description for that product
     * @return string
     *
     * @example productDescription() // Random description
     * @example productDescription('Standard Item') // 'Professional-grade item with excellent durability.'
     */
    public function productDescription(?string $name = null): string
    {
        if ($name !== null) {
            $product = $this->findProductByName($name);
            return $product['description'];
        }

        return static::randomElement(static::$products)['description'];
    }

    /**
     * Generate a random product category or get category for specific product.
     *
     * @param string|null $name If provided, returns category for that product
     * @return string
     *
     * @example productCategory() // Random category
     * @example productCategory('Standard Item') // 'Clothing'
     */
    public function productCategory(?string $name = null): string
    {
        if ($name !== null) {
            $product = $this->findProductByName($name);
            return $product['category'];
        }

        return static::randomElement(static::$products)['category'];
    }

    /**
     * Generate a complete product with name, description, and category.
     *
     * @param string|null $name If provided, returns data for that specific product
     * @return array{name: string, description: string, category: string}
     *
     * @example product() // Random product
     * @example product('Standard Item') // ['name' => 'Standard Item', 'description' => '...', 'category' => 'Clothing']
     */
    public function product(?string $name = null): array
    {
        if ($name !== null) {
            return $this->findProductByName($name);
        }

        return static::randomElement(static::$products);
    }

    /**
     * Find a product by name.
     *
     * @param string $name
     * @return array{name: string, description: string, category: string}
     * @throws \InvalidArgumentException if product not found
     */
    protected function findProductByName(string $name): array
    {
        foreach (static::$products as $product) {
            if ($product['name'] === $name) {
                return $product;
            }
        }

        throw new \InvalidArgumentException("Product '{$name}' not found in available products.");
    }

    /**
     * Get all available product names.
     *
     * @return array<string>
     */
    public function getAvailableProductNames(): array
    {
        return array_column(static::$products, 'name');
    }
}
