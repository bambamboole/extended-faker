<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class TableBlock implements Block
{
    public function __construct(
        public string $html,
    ) {}

    public function toMarkdown(): string
    {
        return $this->html;
    }

    public function toWordPress(): string
    {
        return WordPressBlockSerializer::serialize(
            'table',
            '<figure class="wp-block-table">' . $this->html . '</figure>',
        );
    }
}
