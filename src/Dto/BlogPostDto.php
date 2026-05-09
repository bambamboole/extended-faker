<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use Bambamboole\ExtendedFaker\Content\Block\ParagraphBlock;
use Bambamboole\ExtendedFaker\Content\Content;

class BlogPostDto
{
    public Content $contentBlocks;

    public function __construct(
        public string $slug,
        public string $title,
        public string $content,
        public string $excerpt,
        public string $category,
        public array $tags,
        public string $author,
        public string $publishedAt,
        public int $readingTime,
        public string $locale,
        ?Content $contentBlocks = null,
    ) {
        $this->contentBlocks = $contentBlocks ?? new Content([new ParagraphBlock($content)]);
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'category' => $this->category,
            'tags' => $this->tags,
            'author' => $this->author,
            'publishedAt' => $this->publishedAt,
            'readingTime' => $this->readingTime,
            'locale' => $this->locale,
        ];
    }
}
