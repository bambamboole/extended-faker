<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Formatter;

use Bambamboole\ExtendedFaker\Content\Block;
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
use Bambamboole\ExtendedFaker\Content\Content;
use DOMDocument;
use DOMElement;
use League\CommonMark\CommonMarkConverter;

final class WordPressBlockFormatter
{
    public function fromMarkdown(string $markdown, ?WordPressBlockOptions $options = null): string
    {
        return $this->parseMarkdown($markdown, $options)->toWordPress();
    }

    public function parseMarkdown(string $markdown, ?WordPressBlockOptions $options = null): Content
    {
        $options ??= new WordPressBlockOptions();

        $html = (new CommonMarkConverter())
            ->convert($markdown)
            ->getContent();

        return $this->parseHtml($html, $options);
    }

    public function fromHtml(string $html, ?WordPressBlockOptions $options = null): string
    {
        return $this->parseHtml($html, $options)->toWordPress();
    }

    public function parseHtml(string $html, ?WordPressBlockOptions $options = null): Content
    {
        $options ??= new WordPressBlockOptions();

        $dom = new DOMDocument('1.0', 'UTF-8');
        $previousErrors = libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<' . '?xml encoding="utf-8" ?><body>' . $html . '</body>',
            LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED,
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body === null) {
            return new Content($options->fallbackToHtmlBlock ? [new HtmlBlock($html)] : []);
        }

        $blocks = [];
        foreach ($body->childNodes as $node) {
            if (!$node instanceof DOMElement) {
                continue;
            }

            $block = $this->elementToBlock($node, $dom, $options, count($blocks) === 0);
            if ($block !== null) {
                $blocks[] = $block;
            }
        }

        return new Content($blocks);
    }

    private function elementToBlock(
        DOMElement $element,
        DOMDocument $dom,
        WordPressBlockOptions $options,
        bool $isFirstBlock,
    ): ?Block {
        $name = strtolower($element->nodeName);
        $outerHtml = $dom->saveHTML($element) ?: '';

        return match (true) {
            $this->isHeading($name) => $this->headingBlock($element, $dom, $options, $isFirstBlock),
            $name === 'p' => new ParagraphBlock($this->innerHtml($element, $dom)),
            $name === 'ul' => $this->listBlock($element, $dom),
            $name === 'ol' => $this->listBlock($element, $dom, true),
            $name === 'pre' => $this->codeBlock($element, $dom),
            $name === 'blockquote' => new QuoteBlock($this->innerHtml($element, $dom)),
            $name === 'hr' => new SeparatorBlock(),
            $name === 'img' => $this->imageBlock($element),
            $name === 'figure' => $this->figureBlock($element, $dom, $options),
            $name === 'table' => new TableBlock($outerHtml),
            default => $options->fallbackToHtmlBlock ? new HtmlBlock($outerHtml) : null,
        };
    }

    private function isHeading(string $tagName): bool
    {
        return in_array($tagName, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true);
    }

    private function headingBlock(
        DOMElement $heading,
        DOMDocument $dom,
        WordPressBlockOptions $options,
        bool $isFirstBlock,
    ): ?HeadingBlock {
        $sourceLevel = (int) substr(strtolower($heading->nodeName), 1);

        if ($isFirstBlock && $sourceLevel === 1 && !$options->includeTitleHeading) {
            return null;
        }

        $level = max(1, min(6, $sourceLevel + $options->headingOffset));

        return new HeadingBlock($this->innerHtml($heading, $dom), $level);
    }

    private function innerHtml(DOMElement $element, DOMDocument $dom): string
    {
        $html = '';

        foreach ($element->childNodes as $childNode) {
            $html .= $dom->saveHTML($childNode) ?: '';
        }

        return $html;
    }

    private function listBlock(DOMElement $list, DOMDocument $dom, bool $ordered = false): ListBlock
    {
        $items = [];
        foreach ($list->childNodes as $childNode) {
            if ($childNode instanceof DOMElement && strtolower($childNode->nodeName) === 'li') {
                $items[] = $this->innerHtml($childNode, $dom);
            }
        }

        return new ListBlock($items, $ordered);
    }

    private function codeBlock(DOMElement $pre, DOMDocument $dom): CodeBlock|PreformattedBlock
    {
        $codeNode = $pre->getElementsByTagName('code')->item(0);
        if ($codeNode === null) {
            return new PreformattedBlock($this->innerHtml($pre, $dom));
        }

        return new CodeBlock($dom->saveHTML($codeNode) ?: '');
    }

    private function imageBlock(DOMElement $image): ImageBlock
    {
        return new ImageBlock($image->getAttribute('src'), $image->getAttribute('alt'));
    }

    private function figureBlock(DOMElement $figure, DOMDocument $dom, WordPressBlockOptions $options): ?Block
    {
        $image = $figure->getElementsByTagName('img')->item(0);
        if (!$image instanceof DOMElement) {
            $html = $dom->saveHTML($figure) ?: '';

            return $options->fallbackToHtmlBlock ? new HtmlBlock($html) : null;
        }

        $caption = null;
        $captionNode = $figure->getElementsByTagName('figcaption')->item(0);
        if ($captionNode instanceof DOMElement) {
            $caption = $this->innerHtml($captionNode, $dom);
        }

        return new ImageBlock($image->getAttribute('src'), $image->getAttribute('alt'), $caption);
    }
}
