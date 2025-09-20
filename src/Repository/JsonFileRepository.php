<?php declare(strict_types=1);
namespace Bambamboole\ExtendedFaker\Repository;

abstract class JsonFileRepository
{
    private static array $caches = [];

    public function __construct(
        protected string $resourceSubPath,
        protected string $keyField,
    ) {}

    protected function getItems(): array
    {
        $cacheKey = static::class;
        if (isset(self::$caches[$cacheKey])) {
            return self::$caches[$cacheKey];
        }

        self::$caches[$cacheKey] = [];
        $path = __DIR__ . '/../../resources/' . $this->resourceSubPath;

        foreach (glob($path . '/*.json') as $file) {
            $data = json_decode(file_get_contents($file), true);
            $key = $data[$this->keyField];
            self::$caches[$cacheKey][$key] = $data;
        }

        return self::$caches[$cacheKey];
    }

    public function getAllKeys(): array
    {
        return array_keys($this->getItems());
    }

    protected function getItemByKey(string $key): ?array
    {
        return $this->getItems()[$key] ?? null;
    }

    public function getSupportedLocales(): array
    {
        return ['en_US', 'de_DE'];
    }

    public function hasItemInLocale(string $key, string $locale): bool
    {
        $item = $this->getItemByKey($key);
        return $item && isset($item['locales'][$locale]);
    }

    public function getItemLocales(string $key): array
    {
        $item = $this->getItemByKey($key);
        return $item && isset($item['locales']) ? array_keys($item['locales']) : [];
    }

    public static function clearCache(): void
    {
        if (isset(self::$caches[static::class])) {
            unset(self::$caches[static::class]);
        }
    }
}
