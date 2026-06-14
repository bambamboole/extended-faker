<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use Bambamboole\ExtendedFaker\Content\Content;

final class PageDto
{
    /**
     * @param  array{title: string, description: string}  $seo
     */
    public function __construct(
        public string $slug,
        public string $title,
        public string $content,
        public Content $contentBlocks,
        public string $excerpt,
        public string $template,
        public array $seo,
        public string $locale,
    ) {}

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'template' => $this->template,
            'seo' => $this->seo,
            'locale' => $this->locale,
        ];
    }
}
