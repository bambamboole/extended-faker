<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class QuoteBlock implements Block
{
    public function __construct(
        public string $content,
    ) {}

    public function toMarkdown(): string
    {
        return '> ' . html_entity_decode(strip_tags($this->content), ENT_QUOTES | ENT_HTML5);
    }

    public function toWordPress(): string
    {
        return WordPressBlockSerializer::serialize(
            'quote',
            '<blockquote class="wp-block-quote">' . $this->innerParagraphBlocks() . '</blockquote>',
        );
    }

    private function innerParagraphBlocks(): string
    {
        $content = trim($this->content);

        // Markdown path supplies one or more <p>...</p> elements because CommonMark wraps
        // blockquote contents in paragraphs; fixture path supplies raw text.
        if (!str_contains($content, '<p>')) {
            return $this->wrapParagraph($content);
        }

        return (string) preg_replace_callback(
            '#<p>(.*?)</p>\s*#s',
            fn(array $match): string => $this->wrapParagraph($match[1]),
            $content,
        );
    }

    private function wrapParagraph(string $html): string
    {
        return "<!-- wp:paragraph -->\n<p>{$html}</p>\n<!-- /wp:paragraph -->";
    }
}
