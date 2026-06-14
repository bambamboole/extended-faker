<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Content\ContentFactory;
use Bambamboole\ExtendedFaker\Dto\PageDto;
use Bambamboole\ExtendedFaker\Image\ImagePath;

class PageRepository extends JsonFileRepository
{
    public function __construct()
    {
        parent::__construct('pages', 'slug');
    }

    public function getPageBySlug(string $slug, string $locale = 'en_US'): ?PageDto
    {
        $page = $this->getItemByKey($slug);
        if (! $page || ! isset($page['locales'][$locale])) {
            return null;
        }

        return $this->resolvePage($slug, $page, $locale);
    }

    public function findPageByTitle(string $title, string $locale = 'en_US'): ?PageDto
    {
        foreach ($this->getItems() as $slug => $page) {
            if (isset($page['locales'][$locale]) && $page['locales'][$locale]['title'] === $title) {
                return $this->resolvePage($slug, $page, $locale);
            }
        }

        return null;
    }

    public function getRandomPage(string $locale = 'en_US'): ?PageDto
    {
        $pages = $this->getAllPages($locale);

        return empty($pages) ? null : $pages[array_rand($pages)];
    }

    /** @return list<PageDto> */
    public function getAllPages(string $locale = 'en_US'): array
    {
        $pages = [];
        foreach ($this->getItems() as $slug => $page) {
            if (isset($page['locales'][$locale])) {
                $pages[] = $this->resolvePage($slug, $page, $locale);
            }
        }

        return $pages;
    }

    /** @return list<string> */
    public function getAllSlugs(): array
    {
        return $this->getAllKeys();
    }

    /** @return list<string> */
    public function getAllTitles(string $locale = 'en_US'): array
    {
        $titles = [];
        foreach ($this->getItems() as $page) {
            if (isset($page['locales'][$locale])) {
                $titles[] = $page['locales'][$locale]['title'];
            }
        }

        return $titles;
    }

    public function hasPageInLocale(string $slug, string $locale): bool
    {
        return $this->hasItemInLocale($slug, $locale);
    }

    /**
     * @param  array<string, mixed>  $page
     */
    private function resolvePage(string $slug, array $page, string $locale): PageDto
    {
        $localeData = $page['locales'][$locale];
        $contentBlocks = ContentFactory::fromArray($localeData['blocks']);

        return new PageDto(
            $slug,
            $localeData['title'],
            $contentBlocks->toMarkdown(),
            $contentBlocks,
            $localeData['excerpt'],
            $page['template'],
            $localeData['seo'],
            $locale,
            ImagePath::for('pages', $slug),
        );
    }
}
