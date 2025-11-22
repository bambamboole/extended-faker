<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Dto\BlogPostDto;
use Bambamboole\ExtendedFaker\Generator\BlogPostGenerator;

class BlogPostRepository
{
    private static array $cache = [];
    private static array $slugToSeedMap = [];
    private static array $titleToSeedMap = [];

    private const SEED_RANGE = 10000; // 0-9999 seeds available

    public function __construct(
        private readonly BlogPostGenerator $generator,
    ) {}

    /**
     * Generate a blog post with a specific seed
     * Same seed always produces the same blog post (deterministic)
     */
    public function generateBlogPost(int $seed, ?string $category = null, string $locale = 'en_US'): BlogPostDto
    {
        $cacheKey = $this->buildCacheKey($seed, $category, $locale);

        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        $blogPost = $this->generator->generate($seed, $category, $locale);
        self::$cache[$cacheKey] = $blogPost;

        // Build reverse lookups for slug and title
        $slugKey = $this->buildLookupKey($blogPost->slug, $locale);
        $titleKey = $this->buildLookupKey($blogPost->title, $locale);

        self::$slugToSeedMap[$slugKey] = ['seed' => $seed, 'category' => $category];
        self::$titleToSeedMap[$titleKey] = ['seed' => $seed, 'category' => $category];

        return $blogPost;
    }

    /**
     * Generate a random blog post
     * Uses random seed to ensure variety
     */
    public function generateRandomBlogPost(?string $category = null, string $locale = 'en_US'): BlogPostDto
    {
        $seed = random_int(0, self::SEED_RANGE - 1);
        return $this->generateBlogPost($seed, $category, $locale);
    }

    /**
     * Generate multiple unique blog posts
     */
    public function generateUniqueBatch(int $count, ?string $category = null, string $locale = 'en_US'): array
    {
        $posts = [];
        $seeds = range(0, min($count - 1, self::SEED_RANGE - 1));

        foreach ($seeds as $seed) {
            $posts[] = $this->generateBlogPost($seed, $category, $locale);
        }

        return $posts;
    }

    /**
     * Get a random blog post (alias for generateRandomBlogPost for backward compatibility)
     */
    public function getRandomBlogPost(string $locale = 'en_US'): BlogPostDto
    {
        return $this->generateRandomBlogPost(null, $locale);
    }

    /**
     * Get blog post by slug using reverse lookup map
     * Returns the blog post if it has been generated before, otherwise returns null
     */
    public function getBlogPostBySlug(string $slug, string $locale = 'en_US'): ?BlogPostDto
    {
        $lookupKey = $this->buildLookupKey($slug, $locale);

        // Check if we have a reverse mapping
        if (isset(self::$slugToSeedMap[$lookupKey])) {
            $mapping = self::$slugToSeedMap[$lookupKey];
            return $this->generateBlogPost($mapping['seed'], $mapping['category'], $locale);
        }

        // Fallback: check cache only (in case mapping wasn't built yet)
        foreach (self::$cache as $cached) {
            if ($cached->slug === $slug && $cached->locale === $locale) {
                return $cached;
            }
        }

        return null;
    }

    /**
     * Find blog post by title using reverse lookup map
     * Returns the blog post if it has been generated before, otherwise returns null
     */
    public function findBlogPostByTitle(string $title, string $locale = 'en_US'): ?BlogPostDto
    {
        $lookupKey = $this->buildLookupKey($title, $locale);

        // Check if we have a reverse mapping
        if (isset(self::$titleToSeedMap[$lookupKey])) {
            $mapping = self::$titleToSeedMap[$lookupKey];
            return $this->generateBlogPost($mapping['seed'], $mapping['category'], $locale);
        }

        // Fallback: check cache only (in case mapping wasn't built yet)
        foreach (self::$cache as $cached) {
            if ($cached->title === $title && $cached->locale === $locale) {
                return $cached;
            }
        }

        return null;
    }

    /**
     * Get all blog posts (generates a batch)
     */
    public function getAllBlogPosts(string $locale = 'en_US'): array
    {
        return $this->generateUniqueBatch(100, null, $locale);
    }

    /**
     * Get blog posts by category
     */
    public function getBlogPostsByCategory(string $category, string $locale = 'en_US'): array
    {
        return $this->generateUniqueBatch(50, $category, $locale);
    }

    /**
     * Get all used categories
     */
    public function getUsedCategories(): array
    {
        return ['technology', 'business', 'travel', 'lifestyle'];
    }

    /**
     * Get all slugs from a batch of generated posts
     */
    public function getAllSlugs(): array
    {
        $posts = $this->generateUniqueBatch(100);
        return array_map(fn($post) => $post->slug, $posts);
    }

    /**
     * Get all titles from a batch of generated posts
     */
    public function getAllTitles(string $locale = 'en_US'): array
    {
        $posts = $this->generateUniqueBatch(100, null, $locale);
        return array_map(fn($post) => $post->title, $posts);
    }

    /**
     * Check if blog post exists in locale (always true for generated content)
     */
    public function hasBlogPostInLocale(string $slug, string $locale): bool
    {
        return $this->getBlogPostBySlug($slug, $locale) !== null;
    }

    /**
     * Get supported locales
     */
    public function getSupportedLocales(): array
    {
        return ['en_US', 'de_DE'];
    }

    /**
     * Get item locales (all locales supported for generated content)
     */
    public function getItemLocales(string $slug): array
    {
        return $this->getSupportedLocales();
    }

    /**
     * Build a consistent cache key for storing generated posts
     */
    private function buildCacheKey(int $seed, ?string $category, string $locale): string
    {
        return sprintf('%d_%s_%s', $seed, $category ?? 'null', $locale);
    }

    /**
     * Build a consistent lookup key for reverse mappings
     */
    private function buildLookupKey(string $identifier, string $locale): string
    {
        return sprintf('%s_%s', $identifier, $locale);
    }
}
