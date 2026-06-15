<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\ImageDto;
use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Image\ImagePath;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Random\Engine\Mt19937;
use Random\Randomizer;

final class ProductGenerator
{
    public function __construct(
        private readonly ProductTemplates $templates = new ProductTemplates,
        private readonly CategoryRepository $categories = new CategoryRepository,
    ) {}

    public function generate(int $seed, ?string $category = null, string $locale = 'en_US'): ProductDto
    {
        $random = new Randomizer(new Mt19937($seed));

        $picked = $this->pick($this->templates->categories(), $random);
        $category ??= $picked;
        $template = $this->templates->get($category);

        $values = [];
        foreach ($template['pools'] as $key => $pool) {
            $values['{'.$key.'}'] = $this->pick($pool, $random);
        }
        foreach ($template['variants'] as $key => $pool) {
            $values['{'.$key.'}'] = $this->pick($pool, $random);
        }
        $name = strtr((string) $template['nameTemplate'], $values);

        $localized = $template['locales'][$locale];
        $descTemplate = $this->pick($localized['descriptionTemplates'], $random);

        $descValues = $values;
        $localizedKeys = array_keys($localized);
        sort($localizedKeys);
        foreach ($localizedKeys as $key) {
            if ($key === 'descriptionTemplates') {
                continue;
            }
            $descValues['{'.$key.'}'] = $this->pick($localized[$key], $random);
        }
        $description = strtr((string) $descTemplate, $descValues);

        $sku = ProductSku::encode($this->templates->prefixFor($category), $seed);
        $categoryName = $this->categories->getCategoryName($category, $locale) ?? $category;
        $image = ImageDto::fromPath(ImagePath::for('categories', $category));

        return new ProductDto($sku, $name, $description, $categoryName, $image);
    }

    private function pick(array $items, Randomizer $random): mixed
    {
        $items = array_values($items);

        return $items[$random->getInt(0, count($items) - 1)];
    }
}
