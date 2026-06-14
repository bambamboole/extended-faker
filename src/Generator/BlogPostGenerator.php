<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Content\Block\CodeBlock;
use Bambamboole\ExtendedFaker\Content\Block\HeadingBlock;
use Bambamboole\ExtendedFaker\Content\Block\ParagraphBlock;
use Bambamboole\ExtendedFaker\Content\Content;
use Bambamboole\ExtendedFaker\Dto\BlogPostDto;
use Random\Engine\Mt19937;
use Random\Randomizer;

class BlogPostGenerator
{
    private static ?array $templates = null;

    private const CATEGORIES = ['technology', 'business', 'travel', 'lifestyle'];

    private const WORDS_PER_MINUTE = 200;

    private const MIN_SECTIONS = 4;

    private const MAX_SECTIONS = 5;

    private const MIN_TAGS = 3;

    private const MAX_TAGS = 5;

    private const MIN_NUMBER_PLACEHOLDER = 5;

    private const MAX_NUMBER_PLACEHOLDER = 15;

    public function __construct(
        private readonly string $templatesPath,
    ) {}

    public function generate(int $seed, ?string $category = null, ?string $locale = 'en_US'): BlogPostDto
    {
        $this->loadTemplates();

        $random = new Randomizer(new Mt19937($seed));

        $category ??= self::CATEGORIES[$random->getInt(0, count(self::CATEGORIES) - 1)];

        $title = $this->generateTitle($category, $random);

        $intro = $this->generateIntroduction($category, $title, $random);
        $sectionCount = $random->getInt(self::MIN_SECTIONS, self::MAX_SECTIONS);
        $sections = $this->generateSections($category, $sectionCount, $random);
        $conclusion = $this->generateConclusion($category, $random);

        $codeExample = null;
        if ($category === 'technology' && $random->getInt(0, 1) === 1) {
            $codeExample = $this->generateCodeExample($random);
        }

        $contentBlocks = $this->composeContent($title, $intro, $sections, $codeExample, $conclusion);
        $content = $contentBlocks->toMarkdown();

        $slug = $this->generateSlug($title);
        $excerpt = $this->generateExcerpt($intro);
        $tags = $this->generateTags($category, $random);
        $author = $this->selectAuthor($random);
        $publishedAt = $this->generatePublishedDate($random);
        $readingTime = $this->calculateReadingTime($content);

        return new BlogPostDto(
            slug: $slug,
            title: $title,
            content: $content,
            excerpt: $excerpt,
            category: $category,
            tags: $tags,
            author: $author,
            publishedAt: $publishedAt,
            readingTime: $readingTime,
            locale: $locale,
            contentBlocks: $contentBlocks,
        );
    }

    private function loadTemplates(): void
    {
        if (self::$templates !== null) {
            return;
        }

        $requiredFiles = [
            'titles' => 'titles',
            'introductions' => 'introductions',
            'sections' => 'sections',
            'conclusions' => 'conclusions',
            'codeExamples' => 'code-examples',
            'metadata' => 'metadata',
        ];

        self::$templates = [];

        foreach ($requiredFiles as $templateKey => $fileName) {
            $filePath = $this->templatesPath.'/'.$fileName.'.json';

            if (! file_exists($filePath)) {
                throw new \RuntimeException("Template file not found: {$filePath}");
            }

            if (! is_readable($filePath)) {
                throw new \RuntimeException("Template file not readable: {$filePath}");
            }

            $content = file_get_contents($filePath);
            if ($content === false) {
                throw new \RuntimeException("Failed to read template file: {$filePath}");
            }

            $data = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException(sprintf('Invalid JSON in %s: %s', $filePath, json_last_error_msg()));
            }

            if (! is_array($data)) {
                throw new \RuntimeException("Template file must contain a JSON array or object: {$filePath}");
            }

            self::$templates[$templateKey] = $data;
        }

        $this->validateTemplateStructure();
    }

    private function validateTemplateStructure(): void
    {
        foreach (self::CATEGORIES as $category) {
            if (! isset(self::$templates['titles'][$category])) {
                throw new \RuntimeException("Missing titles for category: {$category}");
            }

            if (! is_array(self::$templates['titles'][$category]) || empty(self::$templates['titles'][$category])) {
                throw new \RuntimeException("Titles for category '{$category}' must be a non-empty array");
            }

            if (! isset(self::$templates['introductions'][$category])) {
                throw new \RuntimeException("Missing introductions for category: {$category}");
            }

            if (
                ! is_array(self::$templates['introductions'][$category])
                || empty(self::$templates['introductions'][$category])
            ) {
                throw new \RuntimeException("Introductions for category '{$category}' must be a non-empty array");
            }

            if (! isset(self::$templates['sections'][$category])) {
                throw new \RuntimeException("Missing sections for category: {$category}");
            }

            if (! is_array(self::$templates['sections'][$category]) || empty(self::$templates['sections'][$category])) {
                throw new \RuntimeException("Sections for category '{$category}' must be a non-empty array");
            }

            if (! isset(self::$templates['conclusions'][$category])) {
                throw new \RuntimeException("Missing conclusions for category: {$category}");
            }

            if (
                ! is_array(self::$templates['conclusions'][$category])
                || empty(self::$templates['conclusions'][$category])
            ) {
                throw new \RuntimeException("Conclusions for category '{$category}' must be a non-empty array");
            }
        }

        $requiredMetadataKeys = ['authors', 'tagsByCategory', 'yearRange'];
        foreach ($requiredMetadataKeys as $key) {
            if (! isset(self::$templates['metadata'][$key])) {
                throw new \RuntimeException("Missing required metadata key: {$key}");
            }
        }

        foreach (self::CATEGORIES as $category) {
            if (! isset(self::$templates['metadata']['tagsByCategory'][$category])) {
                throw new \RuntimeException("Missing tags for category in metadata: {$category}");
            }
        }

        if (
            ! isset(self::$templates['metadata']['yearRange']['min'])
            || ! isset(self::$templates['metadata']['yearRange']['max'])
        ) {
            throw new \RuntimeException("Year range must have 'min' and 'max' keys");
        }
    }

    private function pick(array $items, Randomizer $random): mixed
    {
        return $items[$random->getInt(0, count($items) - 1)];
    }

    private function generateTitle(string $category, Randomizer $random): string
    {
        $template = $this->pick(self::$templates['titles'][$category], $random);

        return $this->fillPlaceholders($template, $category, $random);
    }

    private function generateIntroduction(string $category, string $title, Randomizer $random): string
    {
        $template = $this->pick(self::$templates['introductions'][$category], $random);

        $topic = $this->extractTopicFromTitle($title);

        $intro = str_replace('{title}', $title, $template);
        $intro = str_replace('{topic}', $topic, $intro);

        return $this->fillPlaceholders($intro, $category, $random);
    }

    private function generateSections(string $category, int $count, Randomizer $random): array
    {
        $availableSections = self::$templates['sections'][$category];
        $selectedSections = [];

        $indices = range(0, count($availableSections) - 1);
        $indices = $random->shuffleArray($indices);

        for ($i = 0; $i < min($count, count($availableSections)); $i++) {
            $selectedSections[] = $availableSections[$indices[$i]];
        }

        return $selectedSections;
    }

    private function generateCodeExample(Randomizer $random): ?array
    {
        $category = $this->pick(['php', 'javascript', 'python', 'docker', 'configuration', 'api', 'general'], $random);

        return $this->pick(self::$templates['codeExamples'][$category], $random);
    }

    private function generateConclusion(string $category, Randomizer $random): string
    {
        return $this->pick(self::$templates['conclusions'][$category], $random);
    }

    private function composeContent(
        string $title,
        string $intro,
        array $sections,
        ?array $codeExample,
        string $conclusion,
    ): Content {
        $blocks = [
            new HeadingBlock($title, 1),
            new ParagraphBlock($intro),
        ];

        $codeBlocks = $codeExample !== null ? $this->codeExampleBlocks($codeExample) : [];

        $codeExampleAdded = false;
        foreach ($sections as $index => $section) {
            if ($index === 1 && $codeBlocks !== [] && ! $codeExampleAdded) {
                array_push($blocks, ...$codeBlocks);
                $codeExampleAdded = true;
            }

            $blocks[] = new HeadingBlock($section['heading'], 2);
            $blocks[] = new ParagraphBlock($section['content']);
        }

        if ($codeBlocks !== [] && ! $codeExampleAdded) {
            array_push($blocks, ...$codeBlocks);
        }

        $blocks[] = new HeadingBlock('Conclusion', 2);
        $blocks[] = new ParagraphBlock($conclusion);

        return new Content($blocks);
    }

    /**
     * @param  array<string, mixed>  $codeExample
     * @return list<HeadingBlock|CodeBlock>
     */
    private function codeExampleBlocks(array $codeExample): array
    {
        return [
            new HeadingBlock($codeExample['title'], 3),
            new CodeBlock(htmlspecialchars(
                (string) $codeExample['code'],
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8',
            )),
        ];
    }

    private function generateSlug(string $title): string
    {
        return trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($title)), '-');
    }

    private function generateExcerpt(string $intro): string
    {
        $excerpt = substr($intro, 0, 150);
        $lastSpace = strrpos($excerpt, ' ');

        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt.'...';
    }

    private function generateTags(string $category, Randomizer $random): array
    {
        $tagsByCategory = self::$templates['metadata']['tagsByCategory'][$category];
        $allTags = [];

        foreach ($tagsByCategory as $tagGroup) {
            $allTags = array_merge($allTags, $tagGroup);
        }

        $allTags = $random->shuffleArray($allTags);
        $count = $random->getInt(self::MIN_TAGS, self::MAX_TAGS);

        return array_slice($allTags, 0, min($count, count($allTags)));
    }

    private function selectAuthor(Randomizer $random): string
    {
        return $this->pick(self::$templates['metadata']['authors'], $random);
    }

    private function generatePublishedDate(Randomizer $random): string
    {
        $yearRange = self::$templates['metadata']['yearRange'];
        $startDate = strtotime("{$yearRange['min']}-01-01");
        $endDate = strtotime("{$yearRange['max']}-12-31");

        $randomTimestamp = $random->getInt($startDate, $endDate);

        return date('Y-m-d', $randomTimestamp);
    }

    private function calculateReadingTime(string $content): int
    {
        $text = preg_replace('/```[\s\S]*?```/', '', $content); // Remove code blocks
        $text = preg_replace('/`[^`]*`/', '', (string) $text); // Remove inline code
        $text = preg_replace('/!\[.*?\]\(.*?\)/', '', (string) $text); // Remove images
        $text = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', (string) $text); // Remove links but keep text
        $text = preg_replace('/[#*_\->`]/', '', (string) $text); // Remove markdown characters

        $wordCount = str_word_count((string) $text);
        $readingTime = (int) ceil($wordCount / self::WORDS_PER_MINUTE);

        return max(1, $readingTime);
    }

    private function fillPlaceholders(string $template, string $category, Randomizer $random): string
    {
        $metadata = self::$templates['metadata'];

        $resolvers = [
            '{tech}' => fn () => $this->pick($metadata['techTopics'], $random),
            '{alternative}' => fn () => $this->pick($metadata['techTopics'], $random),
            '{topic}' => fn () => $this->pick($metadata[match ($category) {
                'technology' => 'techTopics',
                'business' => 'businessTopics',
                'travel' => 'travelDestinations',
                'lifestyle' => 'lifestyleTopics',
                default => 'techTopics',
            }], $random),
            '{destination}' => fn () => $this->pick($metadata['travelDestinations'], $random),
            '{year}' => fn () => (string) $random->getInt($metadata['yearRange']['min'], $metadata['yearRange']['max']),
            '{number}' => fn () => (string) $random->getInt(self::MIN_NUMBER_PLACEHOLDER, self::MAX_NUMBER_PLACEHOLDER),
            '{experience}' => fn () => $this->pick(['adventure', 'culture', 'relaxation', 'food', 'nature', 'history'], $random),
            '{Adjective}' => fn () => $this->pick(['Essential', 'Advanced', 'Modern', 'Complete', 'Ultimate', 'Practical'], $random),
            '{Benefit}' => fn () => $this->pick(['Success', 'Best Results', 'Maximum Impact', 'Better Outcomes', 'Peak Performance'], $random),
        ];

        foreach ($resolvers as $placeholder => $resolve) {
            if (str_contains($template, $placeholder)) {
                $template = str_replace($placeholder, $resolve(), $template);
            }
        }

        return $template;
    }

    private function extractTopicFromTitle(string $title): string
    {
        $title = preg_replace(
            '/^(The|A|An|Essential|Introduction to|Guide to|Mastering|Understanding|Getting Started with)\s+/i',
            '',
            $title,
        );

        if (preg_match('/^([^:\-]+)/', (string) $title, $matches)) {
            return trim($matches[1]);
        }

        return $title;
    }
}
