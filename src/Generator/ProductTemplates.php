<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use RuntimeException;

final class ProductTemplates
{
    /** @var array<string, array<string, mixed>>|null */
    private static ?array $cache = null;

    private readonly string $path;

    public function __construct(?string $path = null)
    {
        $this->path = $path ?? __DIR__.'/../../resources/product-templates';
    }

    /** @return list<string> */
    public function categories(): array
    {
        return array_keys($this->all());
    }

    /** @return array<string, mixed> */
    public function get(string $category): array
    {
        $all = $this->all();
        if (! isset($all[$category])) {
            throw new RuntimeException("No product template for category [{$category}].");
        }

        return $all[$category];
    }

    public function prefixFor(string $category): string
    {
        return (string) $this->get($category)['skuPrefix'];
    }

    public function categoryForPrefix(string $prefix): ?string
    {
        foreach ($this->all() as $category => $template) {
            if ($template['skuPrefix'] === $prefix) {
                return $category;
            }
        }

        return null;
    }

    /** @return array<string, array<string, mixed>> */
    private function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        self::$cache = [];
        foreach (glob($this->path.'/*.json') as $file) {
            $category = basename($file, '.json');
            self::$cache[$category] = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        }
        ksort(self::$cache);

        return self::$cache;
    }

    public static function clearCache(): void
    {
        self::$cache = null;
    }
}
