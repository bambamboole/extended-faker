<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content;

use Bambamboole\ExtendedFaker\Content\Block\HeadingBlock;
use Bambamboole\ExtendedFaker\Formatter\WordPressBlockOptions;

final readonly class Content
{
    /** @param list<Block> $blocks */
    public function __construct(
        public array $blocks,
    ) {}

    public function toMarkdown(): string
    {
        return implode("\n\n", array_map(static fn (Block $block): string => $block->toMarkdown(), $this->blocks));
    }

    public function toWordPress(?WordPressBlockOptions $options = null): string
    {
        $options ??= new WordPressBlockOptions;

        $blocks = [];
        foreach ($this->blocks as $block) {
            if (
                count($blocks) === 0
                && $block instanceof HeadingBlock
                && $block->level === 1
                && ! $options->includeTitleHeading
            ) {
                continue;
            }

            if ($block instanceof HeadingBlock && $options->headingOffset !== 0) {
                $blocks[] = $block->withLevel($block->level + $options->headingOffset)->toWordPress();

                continue;
            }

            $blocks[] = $block->toWordPress();
        }

        return implode("\n\n", $blocks);
    }
}
