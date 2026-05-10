<?php
declare(strict_types=1);

use Bambamboole\ExtendedFaker\Content\Content;
use Bambamboole\ExtendedFaker\Dto\PageDto;
use Bambamboole\ExtendedFaker\ExtendedFaker;
use Bambamboole\ExtendedFaker\Formatter\WordPressBlockOptions;
use Bambamboole\ExtendedFaker\Providers\de_DE\Page as PageDe;
use Bambamboole\ExtendedFaker\Providers\en_US\Page;
use Faker\Factory as FakerFactory;

beforeEach(function () {
    $this->faker = FakerFactory::create();
    $this->faker->addProvider(new Page($this->faker));

    $this->fakerDe = FakerFactory::create();
    $this->fakerDe->addProvider(new PageDe($this->fakerDe));
});

test('page fields can be retrieved by slug', function () {
    expect($this->faker->pageTitle('about'))->toBe('About Us');
    expect($this->faker->pageContent('about'))->toContain('# About Us');
    expect($this->faker->pageExcerpt('about'))->toBeString()->not->toBeEmpty();
    expect($this->faker->pageTemplate('about'))->toBeString()->not->toBeEmpty();

    expect($this->faker->pageSeo('about'))
        ->toHaveKeys(['title', 'description'])
        ->and($this->faker->pageSeo('about')['title'])
        ->toBeString()
        ->not->toBeEmpty()->and($this->faker->pageSeo('about')['description'])->toBeString()
        ->not->toBeEmpty();
});

test('page returns dto with markdown content generated from content blocks', function () {
    $page = $this->faker->page('about');

    expect($page)->toBeInstanceOf(PageDto::class);
    expect($page->contentBlocks)->toBeInstanceOf(Content::class);
    expect($page->content)->toBe($page->contentBlocks->toMarkdown());
    expect($page->content)->toContain('# About Us');
});

test('page block content returns wordpress blocks with page title', function () {
    $page = $this->faker->page('about');
    $content = $this->faker->pageBlockContent('about');

    expect($content)
        ->toBe($page->contentBlocks->toWordPress())
        ->toContain('<!-- wp:')
        ->toContain('<!-- /wp:')
        ->toContain('About Us');
});

test('page block content supports wordpress block options', function () {
    $content = $this->faker->pageBlockContent(
        'about',
        new WordPressBlockOptions(includeTitleHeading: false, headingOffset: 1),
    );

    expect($content)->not->toContain('<h1>About Us</h1>')->toContain('<!-- wp:heading {"level":3} -->');
});

test('page lookup by slug and title works', function () {
    expect($this->faker->pageBySlug('about'))->toBeInstanceOf(PageDto::class);
    expect($this->faker->pageBySlug('about')->title)->toBe('About Us');
    expect($this->faker->getPageSlug('About Us'))->toBe('about');
    expect($this->faker->page('About Us')->slug)->toBe('about');
});

test('page can be retrieved from a specific locale', function () {
    $english = $this->faker->page('about');
    $german = $this->faker->getPageInLocale($english->slug, 'de_DE');

    expect($english)->toBeInstanceOf(PageDto::class);
    expect($german)->toBeInstanceOf(PageDto::class);
    expect($english->locale)->toBe('en_US');
    expect($german->locale)->toBe('de_DE');
    expect($german->slug)->toBe($english->slug);
    expect($german->title)->toBe('Über uns');
});

test('invalid explicit page identifier throws exception', function () {
    expect(fn() => $this->faker->page('not-a-real-page'))->toThrow(InvalidArgumentException::class);
    expect(fn() => $this->faker->pageTitle('not-a-real-page'))->toThrow(InvalidArgumentException::class);
    expect(fn() => $this->faker->pageBySlug('not-a-real-page'))->toThrow(InvalidArgumentException::class);
});

test('extended faker registers page providers for en_US and de_DE', function () {
    $faker = FakerFactory::create('en_US');
    ExtendedFaker::extend($faker, 'en_US');

    $fakerDe = FakerFactory::create('de_DE');
    ExtendedFaker::extend($fakerDe, 'de_DE');

    expect($faker->pageTitle('about'))->toBe('About Us');
    expect($fakerDe->pageTitle('about'))->toBe('Über uns');
});
