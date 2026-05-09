<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class ParagraphBlock implements Block
{
    public function __construct(
        public string $content,
    ) {}

    public function toMarkdown(): string
    {
        return html_entity_decode(strip_tags($this->content), ENT_QUOTES | ENT_HTML5);
    }

    public function toWordPress(): string
    {
        return WordPressBlockSerializer::serialize('paragraph', '<p>' . $this->content . '</p>');
    }
}
