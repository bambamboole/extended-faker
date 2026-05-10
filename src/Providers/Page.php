<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Content\Block\HeadingBlock;
use Bambamboole\ExtendedFaker\Content\Block\ParagraphBlock;
use Bambamboole\ExtendedFaker\Content\Content;
use Bambamboole\ExtendedFaker\Dto\PageDto;
use Bambamboole\ExtendedFaker\Formatter\WordPressBlockOptions;
use Bambamboole\ExtendedFaker\Repository\PageRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class Page extends Base
{
    protected PageRepository $repository;

    public function __construct($generator, ?PageRepository $repository = null)
    {
        parent::__construct($generator);
        $this->repository = $repository ?? new PageRepository();
    }

    private function findPage(?string $identifier): ?PageDto
    {
        if ($identifier === null) {
            return $this->normalizePage($this->repository->getRandomPage($this->getLocale()));
        }

        return $this->normalizePage(
            $this->repository->getPageBySlug($identifier, $this->getLocale()) ?? $this->repository->findPageByTitle(
                $identifier,
                $this->getLocale(),
            ),
        );
    }

    public function pageTitle(?string $identifier = null): string
    {
        return $this->page($identifier)->title;
    }

    public function pageContent(?string $identifier = null): string
    {
        return $this->page($identifier)->content;
    }

    public function pageBlockContent(?string $identifier = null, ?WordPressBlockOptions $options = null): string
    {
        return $this->page($identifier)->contentBlocks->toWordPress($options);
    }

    public function pageExcerpt(?string $identifier = null): string
    {
        return $this->page($identifier)->excerpt;
    }

    public function pageTemplate(?string $identifier = null): string
    {
        return $this->page($identifier)->template;
    }

    /** @return array{title: string, description: string} */
    public function pageSeo(?string $identifier = null): array
    {
        return $this->page($identifier)->seo;
    }

    public function page(?string $identifier = null): PageDto
    {
        $page = $this->findPage($identifier);

        if ($page) {
            return $page;
        }

        if ($identifier === null) {
            return $this->samplePage();
        }

        throw new InvalidArgumentException("Page '{$identifier}' not found in locale '{$this->getLocale()}'.");
    }

    public function pageBySlug(string $slug, ?string $locale = null): PageDto
    {
        $targetLocale = $locale ?? $this->getLocale();
        $page = $this->normalizePage($this->repository->getPageBySlug($slug, $targetLocale));

        if (!$page) {
            throw new InvalidArgumentException("Page with slug '{$slug}' not found in locale '{$targetLocale}'.");
        }

        return $page;
    }

    public function getPageSlug(string $title): string
    {
        $page = $this->repository->findPageByTitle($title, $this->getLocale());

        if (!$page) {
            throw new InvalidArgumentException("Page '{$title}' not found in locale '{$this->getLocale()}'.");
        }

        return $page->slug;
    }

    public function getPageInLocale(string $slug, string $locale): PageDto
    {
        $page = $this->normalizePage($this->repository->getPageBySlug($slug, $locale));

        if (!$page) {
            throw new InvalidArgumentException("Page with slug '{$slug}' not found in locale '{$locale}'.");
        }

        return $page;
    }

    private function normalizePage(?PageDto $page): ?PageDto
    {
        if ($page === null) {
            return null;
        }

        $blocks = $page->contentBlocks->blocks;
        $firstBlock = $blocks[0] ?? null;
        if ($firstBlock instanceof HeadingBlock && $firstBlock->level === 1 && $firstBlock->content === $page->title) {
            return $page;
        }

        array_unshift($blocks, new HeadingBlock($page->title, 1));
        $contentBlocks = new Content($blocks);

        return new PageDto(
            $page->slug,
            $page->title,
            $contentBlocks->toMarkdown(),
            $contentBlocks,
            $page->excerpt,
            $page->template,
            $page->seo,
            $page->locale,
        );
    }

    private function samplePage(): PageDto
    {
        $contentBlocks = new Content([
            new HeadingBlock('Sample Page', 1),
            new ParagraphBlock('This is a sample page with some content.'),
        ]);

        return new PageDto(
            slug: 'sample-page',
            title: 'Sample Page',
            content: $contentBlocks->toMarkdown(),
            contentBlocks: $contentBlocks,
            excerpt: 'This is a sample excerpt for a page.',
            template: 'standard',
            seo: [
                'title' => 'Sample Page',
                'description' => 'This is a sample page description.',
            ],
            locale: $this->getLocale(),
        );
    }

    abstract protected function getLocale(): string;
}
