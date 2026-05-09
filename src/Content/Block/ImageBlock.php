<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class ImageBlock implements Block
{
    public function __construct(
        public string $src,
        public string $alt = '',
        public ?string $caption = null,
    ) {}

    public function toMarkdown(): string
    {
        return '![' . $this->alt . '](' . $this->src . ')';
    }

    public function toWordPress(): string
    {
        $img = '<img src="' . $this->src . '" alt="' . $this->alt . '"/>';
        $caption = $this->caption === null ? '' : '<figcaption class="wp-element-caption">' . $this->caption . '</figcaption>';

        return WordPressBlockSerializer::serialize('image', '<figure class="wp-block-image">' . $img . $caption . '</figure>');
    }
}
