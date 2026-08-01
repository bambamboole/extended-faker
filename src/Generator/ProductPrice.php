<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

final class ProductPrice
{
    public const ENDINGS = [49, 95, 99];

    public static function compute(int $base, float $amount, float $referenceAmount, int $endingIndex): int
    {
        $scaled = (int) round($base * $amount / $referenceAmount);
        $ending = self::ENDINGS[$endingIndex % count(self::ENDINGS)];

        return max(intdiv($scaled, 100) * 100 + $ending, $ending);
    }
}
