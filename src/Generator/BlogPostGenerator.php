<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\BlogPostDto;

class BlogPostGenerator
{
    private static ?array $templates = null;

    private const CATEGORIES = ['technology', 'business', 'travel', 'lifestyle'];

    private const WORDS_PER_MINUTE = 200;

    // Content generation parameters
    private const MIN_SECTIONS = 4;
    private const MAX_SECTIONS = 5;
    private const MIN_TAGS = 3;
    private const MAX_TAGS = 5;

    // Placeholder value ranges
    private const MIN_NUMBER_PLACEHOLDER = 5;
    private const MAX_NUMBER_PLACEHOLDER = 15;

    public function __construct(
        private readonly string $templatesPath,
    ) {}

    public function generate(int $seed, ?string $category = null, ?string $locale = 'en_US'): BlogPostDto
    {
        $this->loadTemplates();

        // Create isolated random generator with seed (no global state pollution)
        $random = new \Random\Randomizer(new \Random\Engine\Mt19937($seed));

        // Select category
        $category ??= self::CATEGORIES[$random->getInt(0, count(self::CATEGORIES) - 1)];

        // Generate title
        $title = $this->generateTitle($category, $random);

        // Generate content components
        $intro = $this->generateIntroduction($category, $title, $random);
        // Generate sections to hit target word count
        $sectionCount = $random->getInt(self::MIN_SECTIONS, self::MAX_SECTIONS);
        $sections = $this->generateSections($category, $sectionCount, $random);
        $conclusion = $this->generateConclusion($category, $random);

        // Optionally add a code example for technology posts
        $codeExample = null;
        if ($category === 'technology' && $random->getInt(0, 1) === 1) {
            $codeExample = $this->generateCodeExample($random);
        }

        // Compose full content
        $content = $this->composeContent($title, $intro, $sections, $codeExample, $conclusion);

        // Generate metadata
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
            $filePath = $this->templatesPath . '/' . $fileName . '.json';

            if (!file_exists($filePath)) {
                throw new \RuntimeException("Template file not found: {$filePath}");
            }

            if (!is_readable($filePath)) {
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

            if (!is_array($data)) {
                throw new \RuntimeException("Template file must contain a JSON array or object: {$filePath}");
            }

            self::$templates[$templateKey] = $data;
        }

        $this->validateTemplateStructure();
    }

    private function validateTemplateStructure(): void
    {
        // Validate that all required categories have templates
        foreach (self::CATEGORIES as $category) {
            if (!isset(self::$templates['titles'][$category])) {
                throw new \RuntimeException("Missing titles for category: {$category}");
            }

            if (!is_array(self::$templates['titles'][$category]) || empty(self::$templates['titles'][$category])) {
                throw new \RuntimeException("Titles for category '{$category}' must be a non-empty array");
            }

            if (!isset(self::$templates['introductions'][$category])) {
                throw new \RuntimeException("Missing introductions for category: {$category}");
            }

            if (
                !is_array(self::$templates['introductions'][$category])
                || empty(self::$templates['introductions'][$category])
            ) {
                throw new \RuntimeException("Introductions for category '{$category}' must be a non-empty array");
            }

            if (!isset(self::$templates['sections'][$category])) {
                throw new \RuntimeException("Missing sections for category: {$category}");
            }

            if (!is_array(self::$templates['sections'][$category]) || empty(self::$templates['sections'][$category])) {
                throw new \RuntimeException("Sections for category '{$category}' must be a non-empty array");
            }

            if (!isset(self::$templates['conclusions'][$category])) {
                throw new \RuntimeException("Missing conclusions for category: {$category}");
            }

            if (
                !is_array(self::$templates['conclusions'][$category])
                || empty(self::$templates['conclusions'][$category])
            ) {
                throw new \RuntimeException("Conclusions for category '{$category}' must be a non-empty array");
            }
        }

        // Validate metadata structure
        $requiredMetadataKeys = ['authors', 'tagsByCategory', 'yearRange'];
        foreach ($requiredMetadataKeys as $key) {
            if (!isset(self::$templates['metadata'][$key])) {
                throw new \RuntimeException("Missing required metadata key: {$key}");
            }
        }

        // Validate tagsByCategory has all categories
        foreach (self::CATEGORIES as $category) {
            if (!isset(self::$templates['metadata']['tagsByCategory'][$category])) {
                throw new \RuntimeException("Missing tags for category in metadata: {$category}");
            }
        }

        // Validate year range
        if (
            !isset(self::$templates['metadata']['yearRange']['min'])
            || !isset(self::$templates['metadata']['yearRange']['max'])
        ) {
            throw new \RuntimeException("Year range must have 'min' and 'max' keys");
        }
    }

    private function generateTitle(string $category, \Random\Randomizer $random): string
    {
        $templates = self::$templates['titles'][$category];
        $template = $templates[$random->getInt(0, count($templates) - 1)];

        return $this->fillPlaceholders($template, $category, $random);
    }

    private function generateIntroduction(string $category, string $title, \Random\Randomizer $random): string
    {
        $templates = self::$templates['introductions'][$category];
        $template = $templates[$random->getInt(0, count($templates) - 1)];

        // Extract main topic from title
        $topic = $this->extractTopicFromTitle($title);

        $intro = str_replace('{title}', $title, $template);
        $intro = str_replace('{topic}', $topic, $intro);

        return $intro;
    }

    private function generateSections(string $category, int $count, \Random\Randomizer $random): array
    {
        $availableSections = self::$templates['sections'][$category];
        $selectedSections = [];

        // Randomly select unique sections
        $indices = range(0, count($availableSections) - 1);
        $indices = $random->shuffleArray($indices);

        for ($i = 0; $i < min($count, count($availableSections)); $i++) {
            $selectedSections[] = $availableSections[$indices[$i]];
        }

        return $selectedSections;
    }

    private function generateCodeExample(\Random\Randomizer $random): ?array
    {
        $categories = ['php', 'javascript', 'python', 'docker', 'configuration', 'api', 'general'];
        $category = $categories[$random->getInt(0, count($categories) - 1)];

        $examples = self::$templates['codeExamples'][$category];
        return $examples[$random->getInt(0, count($examples) - 1)];
    }

    private function generateConclusion(string $category, \Random\Randomizer $random): string
    {
        $templates = self::$templates['conclusions'][$category];
        return $templates[$random->getInt(0, count($templates) - 1)];
    }

    private function composeContent(
        string $title,
        string $intro,
        array $sections,
        ?array $codeExample,
        string $conclusion,
    ): string {
        $content = "# {$title}\n\n";
        $content .= "{$intro}\n\n";

        foreach ($sections as $section) {
            $content .= "## {$section['heading']}\n\n";
            $content .= "{$section['content']}\n\n";
        }

        // Insert code example after first section if present
        if ($codeExample !== null && count($sections) > 0) {
            $parts = explode("\n\n## ", $content, 2);
            if (count($parts) === 2) {
                $content = $parts[0] . "\n\n### {$codeExample['title']}\n\n";
                $content .= "```\n{$codeExample['code']}\n```\n\n";
                $content .= '## ' . $parts[1];
            }
        }

        $content .= "## Conclusion\n\n";
        $content .= "{$conclusion}\n";

        return $content;
    }

    private function generateSlug(string $title): string
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim((string) $slug, '-');

        return $slug;
    }

    private function generateExcerpt(string $intro): string
    {
        // Take first 150 characters and add ellipsis
        $excerpt = substr($intro, 0, 150);
        $lastSpace = strrpos($excerpt, ' ');

        if ($lastSpace !== false) {
            $excerpt = substr($excerpt, 0, $lastSpace);
        }

        return $excerpt . '...';
    }

    private function generateTags(string $category, \Random\Randomizer $random): array
    {
        $tagsByCategory = self::$templates['metadata']['tagsByCategory'][$category];
        $allTags = [];

        foreach ($tagsByCategory as $tagGroup) {
            $allTags = array_merge($allTags, $tagGroup);
        }

        // Select random tags
        $allTags = $random->shuffleArray($allTags);
        $count = $random->getInt(self::MIN_TAGS, self::MAX_TAGS);

        return array_slice($allTags, 0, min($count, count($allTags)));
    }

    private function selectAuthor(\Random\Randomizer $random): string
    {
        $authors = self::$templates['metadata']['authors'];
        return $authors[$random->getInt(0, count($authors) - 1)];
    }

    private function generatePublishedDate(\Random\Randomizer $random): string
    {
        $yearRange = self::$templates['metadata']['yearRange'];
        $startDate = strtotime("{$yearRange['min']}-01-01");
        $endDate = strtotime("{$yearRange['max']}-12-31");

        $randomTimestamp = $random->getInt($startDate, $endDate);
        return date('Y-m-d', $randomTimestamp);
    }

    private function calculateReadingTime(string $content): int
    {
        // Remove markdown syntax for accurate word count
        $text = preg_replace('/```[\s\S]*?```/', '', $content); // Remove code blocks
        $text = preg_replace('/`[^`]*`/', '', (string) $text); // Remove inline code
        $text = preg_replace('/!\[.*?\]\(.*?\)/', '', (string) $text); // Remove images
        $text = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', (string) $text); // Remove links but keep text
        $text = preg_replace('/[#*_\->`]/', '', (string) $text); // Remove markdown characters

        $wordCount = str_word_count((string) $text);
        $readingTime = (int) ceil($wordCount / self::WORDS_PER_MINUTE);

        return max(1, $readingTime);
    }

    private function fillPlaceholders(string $template, string $category, \Random\Randomizer $random): string
    {
        $metadata = self::$templates['metadata'];

        // Replace {tech} placeholder
        if (str_contains($template, '{tech}')) {
            $topics = $metadata['techTopics'];
            $template = str_replace('{tech}', $topics[$random->getInt(0, count($topics) - 1)], $template);
        }

        // Replace {alternative} placeholder (for comparison titles)
        if (str_contains($template, '{alternative}')) {
            $topics = $metadata['techTopics'];
            $template = str_replace('{alternative}', $topics[$random->getInt(0, count($topics) - 1)], $template);
        }

        // Replace {topic} placeholder
        if (str_contains($template, '{topic}')) {
            $topicsKey = match ($category) {
                'technology' => 'techTopics',
                'business' => 'businessTopics',
                'travel' => 'travelDestinations',
                'lifestyle' => 'lifestyleTopics',
                default => 'techTopics',
            };
            $topics = $metadata[$topicsKey];
            $template = str_replace('{topic}', $topics[$random->getInt(0, count($topics) - 1)], $template);
        }

        // Replace {destination} placeholder
        if (str_contains($template, '{destination}')) {
            $destinations = $metadata['travelDestinations'];
            $template = str_replace(
                '{destination}',
                $destinations[$random->getInt(0, count($destinations) - 1)],
                $template,
            );
        }

        // Replace {year} placeholder
        if (str_contains($template, '{year}')) {
            $yearRange = $metadata['yearRange'];
            $year = $random->getInt($yearRange['min'], $yearRange['max']);
            $template = str_replace('{year}', (string) $year, $template);
        }

        // Replace {number} placeholder
        if (str_contains($template, '{number}')) {
            $number = $random->getInt(self::MIN_NUMBER_PLACEHOLDER, self::MAX_NUMBER_PLACEHOLDER);
            $template = str_replace('{number}', (string) $number, $template);
        }

        // Replace {experience} placeholder
        if (str_contains($template, '{experience}')) {
            $experiences = ['adventure', 'culture', 'relaxation', 'food', 'nature', 'history'];
            $template = str_replace(
                '{experience}',
                $experiences[$random->getInt(0, count($experiences) - 1)],
                $template,
            );
        }

        // Replace {Adjective} placeholder
        if (str_contains($template, '{Adjective}')) {
            $adjectives = ['Essential', 'Advanced', 'Modern', 'Complete', 'Ultimate', 'Practical'];
            $template = str_replace('{Adjective}', $adjectives[$random->getInt(0, count($adjectives) - 1)], $template);
        }

        // Replace {Benefit} placeholder
        if (str_contains($template, '{Benefit}')) {
            $benefits = ['Success', 'Best Results', 'Maximum Impact', 'Better Outcomes', 'Peak Performance'];
            $template = str_replace('{Benefit}', $benefits[$random->getInt(0, count($benefits) - 1)], $template);
        }

        return $template;
    }

    private function extractTopicFromTitle(string $title): string
    {
        // Simple topic extraction - take the first significant word/phrase
        // Remove common starting words
        $title = preg_replace(
            '/^(The|A|An|Essential|Introduction to|Guide to|Mastering|Understanding|Getting Started with)\s+/i',
            '',
            $title,
        );

        // Extract first major word or phrase (up to colon or dash)
        if (preg_match('/^([^:\-]+)/', (string) $title, $matches)) {
            return trim($matches[1]);
        }

        return $title;
    }
}
