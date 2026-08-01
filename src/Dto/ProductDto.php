<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class ProductDto
{
    public function __construct(
        public string $sku,
        public string $name,
        public string $description,
        public string $category,
        public ?ImageDto $image = null,
        public float $unitAmount = 1.0,
        public string $unit = 'pc',
        public ?MoneyDto $price = null,
    ) {}

    /**
     * @return array{sku: string, name: string, description: string, category: string, image: array{path: string, absolute_path: string, mime_type: string, size: int}|null, unit_amount: float, unit: string, price: array{amount: int, currency: string}|null}
     */
    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'image' => $this->image?->toArray(),
            'unit_amount' => $this->unitAmount,
            'unit' => $this->unit,
            'price' => $this->price?->toArray(),
        ];
    }
}
