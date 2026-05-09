<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class ListBlock implements Block
{
    /** @param list<string> $items */
    public function __construct(
        public array $items,
        public bool $ordered = false,
    ) {}

    public function toMarkdown(): string
    {
        $lines = [];
        foreach ($this->items as $index => $item) {
            $prefix = $this->ordered ? ($index + 1) . '. ' : '- ';
            $lines[] = $prefix . html_entity_decode(strip_tags($item), ENT_QUOTES | ENT_HTML5);
        }

        return implode("\n", $lines);
    }

    public function toWordPress(): string
    {
        $tag = $this->ordered ? 'ol' : 'ul';
        $items = array_map(static fn(string $item): string => '<li>' . $item . '</li>', $this->items);
        $attributes = $this->ordered ? ['ordered' => true] : [];

        return WordPressBlockSerializer::serialize('list', '<' . $tag . '>' . implode('', $items) . '</' . $tag . '>', $attributes);
    }
}
