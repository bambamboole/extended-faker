<?php
declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\PageDto;
use Bambamboole\ExtendedFaker\Repository\PageRepository;

beforeEach(function () {
    $this->repository = new PageRepository();
    PageRepository::clearCache();
});

afterEach(function () {
    PageRepository::clearCache();
});

test('gets all page slugs', function () {
    $expectedSlugs = [
        'about',
        'careers',
        'contact',
        'cookie-policy',
        'faq',
        'investors',
        'press',
        'pricing',
        'privacy',
        'shipping-returns',
        'team',
        'terms',
    ];
    $actualSlugs = $this->repository->getAllSlugs();

    sort($expectedSlugs);
    sort($actualSlugs);

    expect($actualSlugs)->toBe($expectedSlugs);
});

test('gets about page by slug with hydrated content blocks', function () {
    $page = $this->repository->getPageBySlug('about', 'en_US');

    expect($page)->toBeInstanceOf(PageDto::class);
    expect($page->slug)->toBe('about');
    expect($page->title)->toBe('About Us');
    expect($page->locale)->toBe('en_US');
    expect($page->contentBlocks->blocks)->toBeArray()->not->toBeEmpty();
    expect($page->content)->toBe($page->contentBlocks->toMarkdown());
});

test('finds page by title', function () {
    $page = $this->repository->findPageByTitle('About Us', 'en_US');

    expect($page)->toBeInstanceOf(PageDto::class);
    expect($page->slug)->toBe('about');
});

test('gets all german pages', function () {
    $pages = $this->repository->getAllPages('de_DE');

    expect($pages)->toHaveCount(12);
    expect($pages)->each->toBeInstanceOf(PageDto::class);
    expect(array_map(static fn(PageDto $page): string => $page->locale, $pages))->each->toBe('de_DE');
});

test('page fixtures are publication ready', function () {
    foreach (glob(__DIR__ . '/../../resources/pages/*.json') as $fixturePath) {
        $slug = basename($fixturePath, '.json');
        $fixture = json_decode(file_get_contents($fixturePath), true);

        expect($fixture['slug'])->toBe($slug);
        expect($fixture['template'])->toBeString()->not->toBeEmpty();
        expect($fixture['locales'])->toHaveKeys(['en_US', 'de_DE']);

        foreach (['en_US', 'de_DE'] as $locale) {
            $localeData = $fixture['locales'][$locale];

            expect($localeData['title'])->toBeString()->not->toBeEmpty();
            expect($localeData['excerpt'])->toBeString()->not->toBeEmpty();
            expect($localeData['seo'])->toHaveKeys(['title', 'description']);
            expect($localeData['seo']['title'])->toBeString()->not->toBeEmpty();
            expect($localeData['seo']['description'])->toBeString()->not->toBeEmpty();
            expect($localeData['blocks'])->toBeArray();
            expect(count($localeData['blocks']))->toBeGreaterThanOrEqual(3);

            $fixtureText = json_encode($localeData, JSON_THROW_ON_ERROR);
            expect($fixtureText)->not->toMatch('/\{[A-Z][A-Za-z0-9_]*\}/');
            expect($fixtureText)->not->toMatch('/lorem ipsum/i');

            $blockTypes = array_unique(array_map(
                static fn(array $block): string => $block['type'],
                $localeData['blocks'],
            ));
            expect($blockTypes)->not->toBe(['paragraph']);
            expect(count(array_filter($blockTypes, static fn(string $blockType): bool => $blockType !== 'paragraph')))
                ->toBeGreaterThanOrEqual(1);
        }
    }
});
