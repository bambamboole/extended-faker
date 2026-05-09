<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class HtmlBlock implements Block
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
        return WordPressBlockSerializer::serialize('html', $this->html);
    }
}
