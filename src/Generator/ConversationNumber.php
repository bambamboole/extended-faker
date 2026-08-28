<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\ConversationCategory;

final class ConversationNumber
{
    public const TYPE = 'CON';

    private const COUNTRIES = ['DE', 'US'];

    public static function encode(string $country, ConversationCategory $category, int $seed): string
    {
        return ProductSku::encode(self::TYPE.'-'.$country.'-'.$category->code(), $seed);
    }

    /**
     * @return array{country: string, category: ConversationCategory, seed: int}|null
     */
    public static function decode(string $number): ?array
    {
        $decoded = ProductSku::decode($number);
        if ($decoded === null) {
            return null;
        }

        $parts = explode('-', $decoded['prefix']);
        if (count($parts) !== 3 || $parts[0] !== self::TYPE || ! in_array($parts[1], self::COUNTRIES, true)) {
            return null;
        }

        $category = ConversationCategory::fromCode($parts[2]);
        if ($category === null) {
            return null;
        }

        return ['country' => $parts[1], 'category' => $category, 'seed' => $decoded['seed']];
    }
}
