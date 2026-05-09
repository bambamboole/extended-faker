<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content;

final class WordPressBlockSerializer
{
    /** @param array<string, mixed> $attributes */
    public static function serialize(string $name, string $html = '', array $attributes = []): string
    {
        $attrs = self::attributes($attributes);

        return "<!-- wp:{$name}{$attrs} -->\n{$html}\n<!-- /wp:{$name} -->";
    }

    /** @param array<string, mixed> $attributes */
    private static function attributes(array $attributes): string
    {
        if ($attributes === []) {
            return '';
        }

        $json = json_encode($attributes, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        return ' ' . $json;
    }
}
