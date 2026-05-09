<?php
declare(strict_types=1);

use Bambamboole\ExtendedFaker\Content\Block\CodeBlock;
use Bambamboole\ExtendedFaker\Content\Block\HeadingBlock;
use Bambamboole\ExtendedFaker\Content\Block\ListBlock;
use Bambamboole\ExtendedFaker\Content\Block\ParagraphBlock;
use Bambamboole\ExtendedFaker\Content\Block\SeparatorBlock;
use Bambamboole\ExtendedFaker\Content\Content;

it('renders ordered blocks to markdown and wordpress block markup', function () {
    $content = new Content([
        new HeadingBlock('Article Title', 1),
        new ParagraphBlock('Intro paragraph.'),
        new ListBlock(['First item', 'Second item']),
        new CodeBlock('<code class="language-php">echo &#039;Hello&#039;;</code>'),
        new SeparatorBlock(),
    ]);

    expect($content->toMarkdown())->toBe(<<<'MARKDOWN'
        # Article Title

        Intro paragraph.

        - First item
        - Second item

        ```
        echo 'Hello';
        ```

        ---
        MARKDOWN)
        ->and($content->toWordPress())
        ->toContain('<!-- wp:heading {"level":1} -->')
        ->toContain('<h1>Article Title</h1>')
        ->toContain('<!-- wp:paragraph -->')
        ->toContain('<p>Intro paragraph.</p>')
        ->toContain('<!-- wp:list -->')
        ->toContain('<li>First item</li>')
        ->toContain('<!-- wp:code -->')
        ->toContain('<pre class="wp-block-code"><code class="language-php">echo &#039;Hello&#039;;</code></pre>')
        ->toContain('<!-- wp:separator -->');
});
