<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use Bambamboole\ExtendedFaker\Image\ImagePath;
use RuntimeException;

final class ImageDto
{
    public function __construct(
        public string $path,
        public string $absolutePath,
        public string $mimeType,
        public int $size,
    ) {}

    public static function fromPath(string $path): self
    {
        $absolutePath = ImagePath::absolute($path);
        $mimeType = mime_content_type($absolutePath);
        $size = filesize($absolutePath);

        if ($mimeType === false || $size === false) {
            throw new RuntimeException("Unable to inspect image fixture [{$path}].");
        }

        return new self($path, $absolutePath, $mimeType, $size);
    }

    /**
     * @return array{path: string, absolute_path: string, mime_type: string, size: int}
     */
    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'absolute_path' => $this->absolutePath,
            'mime_type' => $this->mimeType,
            'size' => $this->size,
        ];
    }
}
