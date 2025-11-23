<?php declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\BlogPostDto;
use Bambamboole\ExtendedFaker\Repository\BlogPostRepository;
use Faker\Provider\Base;

abstract class BlogPost extends Base
{
    protected BlogPostRepository $repository;

    public function __construct($generator, ?BlogPostRepository $repository = null)
    {
        parent::__construct($generator);
        $this->repository = $repository ?? $this->createDefaultRepository();
    }

    protected function createDefaultRepository(): BlogPostRepository
    {
        $templatesPath = __DIR__ . '/../../resources/blog-templates';
        $blogPostGenerator = new \Bambamboole\ExtendedFaker\Generator\BlogPostGenerator($templatesPath);

        return new BlogPostRepository($blogPostGenerator);
    }

    private function findBlogPost(?string $identifier): ?BlogPostDto
    {
        if ($identifier === null) {
            return $this->repository->getRandomBlogPost($this->getLocale());
        }

        return (
            $this->repository->getBlogPostBySlug(
                $identifier,
                $this->getLocale(),
            ) ?? $this->repository->findBlogPostByTitle($identifier, $this->getLocale())
        );
    }

    public function blogPostTitle(?string $identifier = null): string
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return 'Sample Blog Post';
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->title;
    }

    public function blogPostContent(?string $identifier = null): string
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return "# Sample Blog Post\n\nThis is a sample blog post with some content.";
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->content;
    }

    public function blogPostExcerpt(?string $identifier = null): string
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return 'This is a sample excerpt for a blog post.';
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->excerpt;
    }

    public function blogPostCategory(?string $identifier = null): string
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return 'general';
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->category;
    }

    public function blogPostTags(?string $identifier = null): array
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return ['general', 'blog'];
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->tags;
    }

    public function blogPostAuthor(?string $identifier = null): string
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return 'Anonymous';
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->author;
    }

    public function blogPostReadingTime(?string $identifier = null): int
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return 5;
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost->readingTime;
    }

    public function blogPost(?string $identifier = null): BlogPostDto
    {
        $blogPost = $this->findBlogPost($identifier);

        if (!$blogPost) {
            if ($identifier === null) {
                return new BlogPostDto(
                    slug: 'sample-post',
                    title: 'Sample Blog Post',
                    content: "# Sample Blog Post\n\nThis is a sample blog post with some content.",
                    excerpt: 'This is a sample excerpt for a blog post.',
                    category: 'general',
                    tags: ['general', 'blog'],
                    author: 'Anonymous',
                    publishedAt: date('Y-m-d'),
                    readingTime: 5,
                    locale: $this->getLocale(),
                );
            }
            throw new \InvalidArgumentException("Blog post '{$identifier}' not found in available posts.");
        }

        return $blogPost;
    }

    public function blogPostBySlug(string $slug, ?string $locale = null): BlogPostDto
    {
        $targetLocale = $locale ?? $this->getLocale();
        $blogPost = $this->repository->getBlogPostBySlug($slug, $targetLocale);

        if (!$blogPost) {
            throw new \InvalidArgumentException("Blog post with slug '{$slug}' not found in locale '{$targetLocale}'.");
        }

        return $blogPost;
    }

    public function getBlogPostSlug(string $title): string
    {
        $blogPost = $this->repository->findBlogPostByTitle($title, $this->getLocale());

        if (!$blogPost) {
            throw new \InvalidArgumentException("Blog post '{$title}' not found in locale '{$this->getLocale()}'.");
        }

        return $blogPost->slug;
    }

    public function getBlogPostInLocale(string $slug, string $locale): BlogPostDto
    {
        $blogPost = $this->repository->getBlogPostBySlug($slug, $locale);

        if (!$blogPost) {
            throw new \InvalidArgumentException("Blog post with slug '{$slug}' not found in locale '{$locale}'.");
        }

        return $blogPost;
    }

    abstract protected function getLocale(): string;
}
