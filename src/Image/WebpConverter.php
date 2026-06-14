<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Image;

use Imagick;
use ImagickPixel;
use RuntimeException;

final class WebpConverter
{
    public function toWebp(
        string $svg,
        int $width,
        int $height,
        bool $lossless = true,
        int $quality = 80,
    ): string {
        if (! extension_loaded('imagick')) {
            throw new RuntimeException(
                'The imagick extension is required to build WebP fixture images.',
            );
        }

        $image = new Imagick;
        $image->setBackgroundColor(new ImagickPixel('transparent'));
        $image->readImageBlob($svg);
        $image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
        $image->setImageFormat('webp');

        if ($lossless) {
            $image->setOption('webp:lossless', 'true');
        } else {
            $image->setImageCompressionQuality($quality);
        }

        return $image->getImageBlob();
    }
}
