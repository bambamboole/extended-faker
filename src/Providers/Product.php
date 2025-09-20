<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Repository\ProductRepository;
use Faker\Provider\Base;

abstract class Product extends Base
{
    protected ProductRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new ProductRepository();
    }

    private function findProduct(?string $identifier): ?array
    {
        if ($identifier === null) {
            return $this->repository->getRandomProduct($this->getLocale());
        }
        return (
            $this->repository->getProductBySku($identifier, $this->getLocale()) ?? $this->repository->findProductByName(
                $identifier,
                $this->getLocale(),
            )
        );
    }

    public function productName(?string $identifier = null): string
    {
        $product = $this->findProduct($identifier);
        if (!$product) {
            if ($identifier === null)
                return 'Generic Product';
            throw new \InvalidArgumentException("Product '{$identifier}' not found in available products.");
        }
        return $product['name'];
    }

    public function productDescription(?string $identifier = null): string
    {
        $product = $this->findProduct($identifier);
        if (!$product) {
            if ($identifier === null)
                return 'A high-quality product designed for everyday use.';
            throw new \InvalidArgumentException("Product '{$identifier}' not found in available products.");
        }
        return $product['description'];
    }

    public function productCategory(?string $identifier = null): string
    {
        $product = $this->findProduct($identifier);
        if (!$product) {
            if ($identifier === null)
                return 'Electronics';
            throw new \InvalidArgumentException("Product '{$identifier}' not found in available products.");
        }
        return $product['category'];
    }

    public function product(?string $identifier = null): array
    {
        $product = $this->findProduct($identifier);
        if (!$product) {
            if ($identifier === null) {
                return [
                    'name' => 'Generic Product',
                    'description' => 'A high-quality product designed for everyday use.',
                    'category' => 'Electronics',
                    'sku' => 'GENERIC-001',
                ];
            }
            throw new \InvalidArgumentException("Product '{$identifier}' not found in available products.");
        }
        return $product;
    }

    public function productBySku(string $sku, ?string $locale = null): array
    {
        $targetLocale = $locale ?? $this->getLocale();
        $product = $this->repository->getProductBySku($sku, $targetLocale);
        if (!$product)
            throw new \InvalidArgumentException("Product with SKU '{$sku}' not found in locale '{$targetLocale}'.");
        return $product;
    }

    public function getProductSku(string $name): string
    {
        $product = $this->repository->findProductByName($name, $this->getLocale());
        if (!$product) {
            throw new \InvalidArgumentException("Product '{$name}' not found in locale '{$this->getLocale()}'.");
        }
        return $product['sku'];
    }

    public function getProductInLocale(string $sku, string $locale): array
    {
        $product = $this->repository->getProductBySku($sku, $locale);
        if (!$product) {
            throw new \InvalidArgumentException("Product with SKU '{$sku}' not found in locale '{$locale}'.");
        }
        return $product;
    }

    abstract protected function getLocale(): string;
}
