<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\ImageDto;
use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class Product extends Base
{
    protected ProductRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new ProductRepository;
    }

    private function resolve(?string $identifier): ProductDto
    {
        if ($identifier === null) {
            return $this->repository->getRandomProduct($this->getLocale());
        }

        $product = $this->repository->getProductBySku($identifier, $this->getLocale());
        if ($product === null) {
            throw new InvalidArgumentException("Product with SKU '{$identifier}' not found.");
        }

        return $product;
    }

    public function product(?string $identifier = null): ProductDto
    {
        return $this->resolve($identifier);
    }

    public function generateProduct(int $seed, ?string $category = null, ?string $locale = null): ProductDto
    {
        return $this->repository->generate($seed, $category, $locale ?? $this->getLocale());
    }

    public function productName(?string $identifier = null): string
    {
        return $this->resolve($identifier)->name;
    }

    public function productDescription(?string $identifier = null): string
    {
        return $this->resolve($identifier)->description;
    }

    public function productCategory(?string $identifier = null): string
    {
        return $this->resolve($identifier)->category;
    }

    public function productImage(?string $identifier = null): ?string
    {
        return $this->resolve($identifier)->image?->path;
    }

    public function productImageDto(?string $identifier = null): ?ImageDto
    {
        return $this->resolve($identifier)->image;
    }

    public function productBySku(string $sku, ?string $locale = null): ProductDto
    {
        $product = $this->repository->getProductBySku($sku, $locale ?? $this->getLocale());
        if ($product === null) {
            throw new InvalidArgumentException("Product with SKU '{$sku}' not found.");
        }

        return $product;
    }

    public function getProductInLocale(string $sku, string $locale): ProductDto
    {
        return $this->productBySku($sku, $locale);
    }

    abstract protected function getLocale(): string;
}
