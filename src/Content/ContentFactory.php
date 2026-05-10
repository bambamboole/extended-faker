<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content;

use Bambamboole\ExtendedFaker\Content\Block\CodeBlock;
use Bambamboole\ExtendedFaker\Content\Block\HeadingBlock;
use Bambamboole\ExtendedFaker\Content\Block\HtmlBlock;
use Bambamboole\ExtendedFaker\Content\Block\ImageBlock;
use Bambamboole\ExtendedFaker\Content\Block\ListBlock;
use Bambamboole\ExtendedFaker\Content\Block\ParagraphBlock;
use Bambamboole\ExtendedFaker\Content\Block\PreformattedBlock;
use Bambamboole\ExtendedFaker\Content\Block\QuoteBlock;
use Bambamboole\ExtendedFaker\Content\Block\SeparatorBlock;
use Bambamboole\ExtendedFaker\Content\Block\TableBlock;
use InvalidArgumentException;

final class ContentFactory
{
    /** @param list<array<string, mixed>> $blocks */
    public static function fromArray(array $blocks): Content
    {
        return new Content(array_values(array_map(self::blockFromArray(
            ...
        ), $blocks)));
    }

    /** @param array<string, mixed> $block */
    private static function blockFromArray(array $block): Block
    {
        return match ((string) ($block['type'] ?? '')) {
            'heading' => new HeadingBlock((string) ($block['content'] ?? ''), (int) ($block['level'] ?? 2)),
            'paragraph' => new ParagraphBlock((string) ($block['content'] ?? '')),
            'list' => new ListBlock(
                array_map(static fn(mixed $item): string => (string) $item, (array) ($block['items'] ?? [])),
                (bool) ($block['ordered'] ?? false),
            ),
            'quote' => new QuoteBlock((string) ($block['content'] ?? '')),
            'separator' => new SeparatorBlock(),
            'code' => new CodeBlock(htmlspecialchars(
                (string) ($block['content'] ?? ''),
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8',
            )),
            'preformatted' => new PreformattedBlock((string) ($block['content'] ?? '')),
            'image' => new ImageBlock(
                (string) ($block['src'] ?? ''),
                (string) ($block['alt'] ?? ''),
                isset($block['caption']) ? (string) $block['caption'] : null,
            ),
            'table' => new TableBlock((string) ($block['html'] ?? '')),
            'html' => new HtmlBlock((string) ($block['html'] ?? '')),
            default => throw new InvalidArgumentException(sprintf(
                'Unsupported content block type: %s',
                (string) ($block['type'] ?? ''),
            )),
        };
    }
}
