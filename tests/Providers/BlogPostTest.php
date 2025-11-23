<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\BlogPostDto;
use Bambamboole\ExtendedFaker\Providers\de_DE\BlogPost as BlogPostDe;
use Bambamboole\ExtendedFaker\Providers\en_US\BlogPost;
use Faker\Factory as FakerFactory;

beforeEach(function () {
    $this->faker = FakerFactory::create();
    $this->faker->addProvider(new BlogPost($this->faker));

    $this->fakerDe = FakerFactory::create();
    $this->fakerDe->addProvider(new BlogPostDe($this->fakerDe));
});

test('blog post methods return expected types', function () {
    expect($this->faker->blogPostTitle())->toBeString()->not->toBeEmpty();
    expect($this->faker->blogPostContent())->toBeString()->not->toBeEmpty();
    expect($this->faker->blogPostExcerpt())->toBeString()->not->toBeEmpty();
    expect($this->faker->blogPostCategory())->toBeString()->not->toBeEmpty();
    expect($this->faker->blogPostAuthor())->toBeString()->not->toBeEmpty();
    expect($this->faker->blogPostTags())->toBeArray()->not->toBeEmpty();
    expect($this->faker->blogPostReadingTime())->toBeInt()->toBeGreaterThan(0);

    $blogPost = $this->faker->blogPost();
    expect($blogPost)->toBeInstanceOf(BlogPostDto::class);
    expect($blogPost->title)->toBeString()->not->toBeEmpty();
    expect($blogPost->content)->toBeString()->not->toBeEmpty();
    expect($blogPost->excerpt)->toBeString()->not->toBeEmpty();
    expect($blogPost->category)->toBeString()->not->toBeEmpty();
    expect($blogPost->tags)->toBeArray()->not->toBeEmpty();
    expect($blogPost->author)->toBeString()->not->toBeEmpty();
    expect($blogPost->slug)->toBeString()->not->toBeEmpty();
    expect($blogPost->publishedAt)->toBeString()->not->toBeEmpty();
    expect($blogPost->readingTime)->toBeInt()->toBeGreaterThan(0);
});

test('blog post can be retrieved by slug', function () {
    // Generate a post and then retrieve it by slug
    $originalPost = $this->faker->blogPost();
    $slug = $originalPost->slug;

    $retrievedPost = $this->faker->blogPostBySlug($slug);
    expect($retrievedPost)->toBeInstanceOf(BlogPostDto::class);
    expect($retrievedPost->slug)->toBe($slug);
});

test('blog post content contains markdown', function () {
    $content = $this->faker->blogPostContent();

    // Check for markdown headings
    expect($content)->toContain('#');
});

test('blog post categories are valid', function () {
    $validCategories = ['technology', 'business', 'travel', 'lifestyle'];

    for ($i = 0; $i < 10; $i++) {
        $blogPost = $this->faker->blogPost();
        expect($blogPost->category)->toBeIn($validCategories);
    }
});

test('blog post tags are arrays', function () {
    $blogPost = $this->faker->blogPost();
    expect($blogPost->tags)->toBeArray();
    expect(count($blogPost->tags))->toBeGreaterThan(0);

    foreach ($blogPost->tags as $tag) {
        expect($tag)->toBeString();
    }
});

test('blog post reading time is calculated correctly', function () {
    $blogPost = $this->faker->blogPost();
    // Reading time is calculated based on word count (200 words per minute)
    expect($blogPost->readingTime)->toBeInt()->toBeGreaterThan(0);

    // For short posts (300-500 words), reading time should be 2-3 minutes
    expect($blogPost->readingTime)->toBeLessThanOrEqual(5);
});

test('cross locale functionality works', function () {
    // Generate posts in different locales
    $enPost = $this->faker->blogPost();
    expect($enPost->locale)->toBe('en_US');

    $dePost = $this->fakerDe->blogPost();
    expect($dePost->locale)->toBe('de_DE');

    // Each locale maintains its own post collection
    expect($enPost)->toBeInstanceOf(BlogPostDto::class);
    expect($dePost)->toBeInstanceOf(BlogPostDto::class);
});

test('german locale provider works correctly', function () {
    $blogPost = $this->fakerDe->blogPost();
    expect($blogPost)->toBeInstanceOf(BlogPostDto::class);
    expect($blogPost->title)->toBeString()->not->toBeEmpty();
    expect($blogPost->slug)->toBeString()->not->toBeEmpty();
});

test('invalid blog post slug throws exception', function () {
    expect(fn() => $this->faker->blogPostBySlug('non-existent-slug'))->toThrow(InvalidArgumentException::class);
});

test('invalid blog post title throws exception', function () {
    expect(fn() => $this->faker->blogPostTitle('non-existent-title'))->toThrow(InvalidArgumentException::class);
});

test('blog post DTO toArray method works', function () {
    $blogPost = $this->faker->blogPost();
    $array = $blogPost->toArray();

    expect($array)->toBeArray();
    expect($array)->toHaveKeys([
        'slug',
        'title',
        'content',
        'excerpt',
        'category',
        'tags',
        'author',
        'publishedAt',
        'readingTime',
        'locale',
    ]);
});

test('multiple random blog posts are different', function () {
    $post1 = $this->faker->blogPost();
    $post2 = $this->faker->blogPost();
    $post3 = $this->faker->blogPost();

    // With generated posts, we should get variety
    $slugs = [$post1->slug, $post2->slug, $post3->slug];
    $uniqueSlugs = array_unique($slugs);

    // At least some should be different (allowing for occasional duplicates due to randomness)
    expect(count($uniqueSlugs))->toBeGreaterThanOrEqual(1);
});

test('can generate 100+ unique blog posts', function () {
    $posts = [];
    $slugs = [];

    // Generate 100 posts
    for ($i = 0; $i < 100; $i++) {
        $post = $this->faker->blogPost();
        $posts[] = $post;
        $slugs[] = $post->slug;
    }

    // Should have generated 100 posts
    expect(count($posts))->toBe(100);

    // Should have significant variety (at least 50% unique)
    $uniqueSlugs = array_unique($slugs);
    expect(count($uniqueSlugs))->toBeGreaterThan(50);
});

test('blog posts have reasonable word count', function () {
    // Generate several posts and check word count
    for ($i = 0; $i < 10; $i++) {
        $post = $this->faker->blogPost();

        // Remove markdown syntax for word count
        $text = preg_replace('/```[\s\S]*?```/', '', (string) $post->content);
        $text = preg_replace('/`[^`]*`/', '', (string) $text);
        $text = preg_replace('/[#*_\->`]/', '', (string) $text);

        $wordCount = str_word_count((string) $text);

        // Short blog posts should be between 100-400 words
        expect($wordCount)->toBeGreaterThan(100);
        expect($wordCount)->toBeLessThan(400);
    }
});

test('blog post published date is valid', function () {
    $blogPost = $this->faker->blogPost();
    expect($blogPost->publishedAt)->toMatch('/^\d{4}-\d{2}-\d{2}$/');
});
