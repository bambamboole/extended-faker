<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

final class ProductSku
{
    public static function encode(string $prefix, int $seed): string
    {
        return $prefix.'-'.strtoupper(base_convert((string) $seed, 10, 36));
    }

    /**
     * @return array{prefix: string, seed: int}|null
     */
    public static function decode(string $sku): ?array
    {
        $dash = strrpos($sku, '-');
        if ($dash === false || $dash === 0 || $dash === strlen($sku) - 1) {
            return null;
        }

        $prefix = substr($sku, 0, $dash);
        $code = substr($sku, $dash + 1);

        return ['prefix' => $prefix, 'seed' => (int) base_convert($code, 36, 10)];
    }
}
