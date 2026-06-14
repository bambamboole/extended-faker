<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class CodeBlock implements Block
{
    public function __construct(
        public string $codeHtml,
    ) {}

    public function toMarkdown(): string
    {
        return "```\n".html_entity_decode(strip_tags($this->codeHtml), ENT_QUOTES | ENT_HTML5)."\n```";
    }

    public function toWordPress(): string
    {
        return WordPressBlockSerializer::serialize('code', '<pre class="wp-block-code">'.$this->codeHtml.'</pre>');
    }
}
