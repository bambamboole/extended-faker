<?php
declare(strict_types=1);

use Bambamboole\ExtendedFaker\Content\Content;
use Bambamboole\ExtendedFaker\Content\ContentFactory;

it('hydrates fixture block definitions into content', function () {
    $content = ContentFactory::fromArray([
        ['type' => 'heading', 'level' => 1, 'content' => 'About Us'],
        ['type' => 'paragraph', 'content' => 'We shipped the roadmap, then asked it how it felt.'],
        ['type' => 'list', 'items' => ['Tiny buttons', 'Large opinions'], 'ordered' => false],
        ['type' => 'quote', 'content' => 'Move fast and document the weird parts.'],
        ['type' => 'separator'],
        ['type' => 'code', 'content' => 'echo "<ship & win>";'],
        ['type' => 'preformatted', 'content' => 'Status: cautiously optimistic'],
        [
            'type' => 'image',
            'src' => 'https://example.com/team.jpg',
            'alt' => 'Team photo',
            'caption' => 'Everyone blinked asynchronously.',
        ],
        ['type' => 'table', 'html' => '<table><tbody><tr><td>Plan</td><td>Snacks</td></tr></tbody></table>'],
        ['type' => 'html', 'html' => '<aside>Legally decorative sidebar.</aside>'],
    ]);

    $wordpress = $content->toWordPress();

    expect($content)
        ->toBeInstanceOf(Content::class)
        ->and($content->blocks)
        ->toHaveCount(10)
        ->and($content->toMarkdown())
        ->toContain('# About Us')
        ->and($wordpress)
        ->toContain('<!-- wp:paragraph -->')
        ->toContain('<p>We shipped the roadmap, then asked it how it felt.</p>')
        ->toContain('<!-- wp:list -->')
        ->toContain('<li>Tiny buttons</li>')
        ->toContain('<li>Large opinions</li>')
        ->toContain('<!-- wp:quote -->')
        ->toContain('<blockquote>Move fast and document the weird parts.</blockquote>')
        ->toContain('<!-- wp:separator -->')
        ->toContain('<!-- wp:code -->')
        ->toContain('<pre class="wp-block-code">echo &quot;&lt;ship &amp; win&gt;&quot;;</pre>')
        ->toContain('<!-- wp:preformatted -->')
        ->toContain('<pre class="wp-block-preformatted">Status: cautiously optimistic</pre>')
        ->toContain('<!-- wp:image -->')
        ->toContain('<img src="https://example.com/team.jpg" alt="Team photo"/>')
        ->toContain('<figcaption class="wp-element-caption">Everyone blinked asynchronously.</figcaption>')
        ->toContain('<!-- wp:table -->')
        ->toContain('<table><tbody><tr><td>Plan</td><td>Snacks</td></tr></tbody></table>')
        ->toContain('<!-- wp:html -->')
        ->toContain('<aside>Legally decorative sidebar.</aside>');
});

it('rejects unknown fixture block types', function () {
    expect(fn() => ContentFactory::fromArray([
        ['type' => 'accordion-of-regret', 'content' => 'Nope'],
    ]))
        ->toThrow(InvalidArgumentException::class, 'Unsupported content block type');
});
