<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class BlogPostDto
{
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
    ) {}

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
