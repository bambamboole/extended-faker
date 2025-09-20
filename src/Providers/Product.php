<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Faker\Provider\Base;

class Product extends Base
{
    /**
     * Default product names (will be overridden by locale providers)
     */
    protected static $productNames = [
        'Generic Product',
        'Standard Item',
        'Basic Product',
        'Essential Item',
        'Universal Product',
    ];

    /**
     * Default product descriptions (will be overridden by locale providers)
     */
    protected static $productDescriptions = [
        'A high-quality product designed for everyday use.',
        'Professional-grade item with excellent durability.',
        'Essential product for modern lifestyle.',
        'Reliable and efficient solution for your needs.',
        'Premium quality item with outstanding performance.',
    ];

    /**
     * Default product categories (will be overridden by locale providers)
     */
    protected static $productCategories = [
        'Electronics',
        'Clothing',
        'Home & Garden',
        'Books',
        'Food',
        'Sports',
        'Automotive',
        'Health',
    ];

    /**
     * Generate a random product name.
     *
     * @example 'Samsung Galaxy S24'
     */
    public function productName(): string
    {
        return static::randomElement(static::$productNames);
    }

    /**
     * Generate a random product description.
     *
     * @example 'High-quality smartphone with cutting-edge technology.'
     */
    public function productDescription(): string
    {
        return static::randomElement(static::$productDescriptions);
    }

    /**
     * Generate a random product category.
     *
     * @example 'Electronics'
     */
    public function productCategory(): string
    {
        return static::randomElement(static::$productCategories);
    }

    /**
     * Generate a complete product with name, description, and category.
     *
     * @return array{name: string, description: string, category: string}
     *
     * @example ['name' => 'Samsung Galaxy S24', 'description' => 'High-quality...', 'category' => 'Electronics']
     */
    public function product(): array
    {
        return [
            'name' => $this->productName(),
            'description' => $this->productDescription(),
            'category' => $this->productCategory(),
        ];
    }
}
