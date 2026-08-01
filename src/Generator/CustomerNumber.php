<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

final class CustomerNumber
{
    public const TYPE_PRIVATE = 'CUS';

    public const TYPE_COMPANY = 'BUS';

    public const TYPE_SUPPLIER = 'SUP';

    private const TYPES = [self::TYPE_PRIVATE, self::TYPE_COMPANY, self::TYPE_SUPPLIER];

    private const COUNTRIES = ['DE', 'US'];

    public static function encode(string $type, string $country, int $seed): string
    {
        return ProductSku::encode($type.'-'.$country, $seed);
    }

    /**
     * @return array{type: string, country: string, seed: int}|null
     */
    public static function decode(string $number): ?array
    {
        $decoded = ProductSku::decode($number);
        if ($decoded === null) {
            return null;
        }

        $parts = explode('-', $decoded['prefix']);
        if (count($parts) !== 2 || ! in_array($parts[0], self::TYPES, true) || ! in_array($parts[1], self::COUNTRIES, true)) {
            return null;
        }

        return ['type' => $parts[0], 'country' => $parts[1], 'seed' => $decoded['seed']];
    }
}
