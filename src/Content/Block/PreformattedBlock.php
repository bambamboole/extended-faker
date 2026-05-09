<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class PreformattedBlock implements Block
{
    public function __construct(
        public string $content,
    ) {}

    public function toMarkdown(): string
    {
        return $this->content;
    }

    public function toWordPress(): string
    {
        return WordPressBlockSerializer::serialize(
            'preformatted',
            '<pre class="wp-block-preformatted">' . $this->content . '</pre>',
        );
    }
}
