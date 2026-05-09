<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;
use Bambamboole\ExtendedFaker\Content\WordPressBlockSerializer;

final readonly class HeadingBlock implements Block
{
    public int $level;

    public function __construct(
        public string $content,
        int $level = 2,
    ) {
        $this->level = self::clampLevel($level);
    }

    public function withLevel(int $level): self
    {
        return new self($this->content, $level);
    }

    public function toMarkdown(): string
    {
        return str_repeat('#', $this->level) . ' ' . $this->content;
    }

    public function toWordPress(): string
    {
        $html = sprintf('<h%d>%s</h%d>', $this->level, $this->content, $this->level);
        $attributes = $this->level === 2 ? [] : ['level' => $this->level];

        return WordPressBlockSerializer::serialize('heading', $html, $attributes);
    }

    private static function clampLevel(int $level): int
    {
        return max(1, min(6, $level));
    }
}
