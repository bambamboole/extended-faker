<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

final class ImagePath
{
    public static function for(string $type, string $key): string
    {
        return 'images/'.$type.'/'.$key.'.webp';
    }

    public static function absolute(string $path): string
    {
        return dirname(__DIR__, 2).'/resources/'.ltrim($path, '/');
    }
}
