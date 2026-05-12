<?php
declare(strict_types=1);

use Bambamboole\ExtendedFaker\Content\Content;
use Bambamboole\ExtendedFaker\Formatter\WordPressBlockFormatter;
use Bambamboole\ExtendedFaker\Formatter\WordPressBlockOptions;

it('converts common markdown nodes to wordpress block markup', function () {
    $blocks = (new WordPressBlockFormatter())->fromMarkdown(<<<'MARKDOWN'
        # Article Title

        Intro paragraph with **strong text**.

        ## Section Title

        - First item
        - Second item

        1. First ordered
        2. Second ordered

        > A quoted thought.

        ```php
        echo 'Hello';
        ```

        ---
        MARKDOWN);

    expect($blocks)
        ->toContain('<!-- wp:heading {"level":1} -->')
        ->toContain('<h1>Article Title</h1>')
        ->toContain('<!-- wp:paragraph -->')
        ->toContain('<p>Intro paragraph with <strong>strong text</strong>.</p>')
        ->toContain('<!-- wp:heading -->')
        ->toContain('<h2>Section Title</h2>')
        ->toContain('<!-- wp:list -->')
        ->toContain('<!-- wp:list {"ordered":true} -->')
        ->toContain('<!-- wp:quote -->')
        ->toContain(
            "<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n"
            . "<p>A quoted thought.</p>\n"
            . '<!-- /wp:paragraph --></blockquote>',
        )
        ->toContain('<!-- wp:code -->')
        ->toContain('<pre class="wp-block-code"><code class="language-php">')
        ->toContain('<!-- wp:separator -->');
});

it('parses markdown into content blocks', function () {
    $content = (new WordPressBlockFormatter())->parseMarkdown(<<<'MARKDOWN'
        # Article Title

        Intro paragraph.
        MARKDOWN);

    expect($content)
        ->toBeInstanceOf(Content::class)
        ->and($content->toMarkdown())
        ->toContain('# Article Title')
        ->toContain('Intro paragraph.')
        ->and($content->toWordPress())
        ->toContain('<!-- wp:heading {"level":1} -->')
        ->toContain('<!-- wp:paragraph -->');
});

it('maps image table and preformatted html to dedicated blocks', function () {
    $blocks = (new WordPressBlockFormatter())->fromHtml(<<<'HTML'
        <figure><img src="https://example.com/image.jpg" alt="Example"><figcaption>Image caption</figcaption></figure>
        <table><tbody><tr><td>Cell</td></tr></tbody></table>
        <pre>Preformatted text</pre>
        HTML);

    expect($blocks)
        ->toContain('<!-- wp:image -->')
        ->toContain(
            '<figure class="wp-block-image"><img src="https://example.com/image.jpg" alt="Example"/><figcaption class="wp-element-caption">Image caption</figcaption></figure>',
        )
        ->toContain('<!-- wp:table -->')
        ->toContain('<figure class="wp-block-table"><table><tbody><tr><td>Cell</td></tr></tbody></table></figure>')
        ->toContain('<!-- wp:preformatted -->')
        ->toContain('<pre class="wp-block-preformatted">Preformatted text</pre>');
});

it('renders multi-paragraph blockquotes as nested paragraph blocks', function () {
    $blocks = (new WordPressBlockFormatter())->fromMarkdown(<<<'MARKDOWN'
        > First line.
        >
        > Second line.
        MARKDOWN);

    expect($blocks)
        ->toContain('<!-- wp:quote -->')
        ->toContain('<blockquote class="wp-block-quote">')
        ->toContain("<!-- wp:paragraph -->\n<p>First line.</p>\n<!-- /wp:paragraph -->")
        ->toContain("<!-- wp:paragraph -->\n<p>Second line.</p>\n<!-- /wp:paragraph -->");
});

it('can omit the first h1 and offset heading levels', function () {
    $blocks = (new WordPressBlockFormatter())->fromMarkdown(
        "# Article Title\n\n## Section Title",
        new WordPressBlockOptions(includeTitleHeading: false, headingOffset: 1),
    );

    expect($blocks)
        ->not
        ->toContain('Article Title')
        ->toContain('<!-- wp:heading {"level":3} -->')
        ->toContain('<h3>Section Title</h3>');
});

it('wraps unsupported top-level html in an html block', function () {
    $blocks = (new WordPressBlockFormatter())->fromHtml('<aside>Custom HTML</aside>');

    expect($blocks)
        ->toContain('<!-- wp:html -->')
        ->toContain('<aside>Custom HTML</aside>')
        ->toContain('<!-- /wp:html -->');
});

it('can skip unsupported top-level html fallback blocks', function () {
    $blocks = (new WordPressBlockFormatter())->fromHtml(
        '<aside>Custom HTML</aside>',
        new WordPressBlockOptions(fallbackToHtmlBlock: false),
    );

    expect($blocks)->toBe('');
});
