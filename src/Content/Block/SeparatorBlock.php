<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content\Block;

use Bambamboole\ExtendedFaker\Content\Block;

final readonly class SeparatorBlock implements Block
{
    public function toMarkdown(): string
    {
        return '---';
    }

    public function toWordPress(): string
    {
        return '<!-- wp:separator --><hr class="wp-block-separator has-alpha-channel-opacity"/><!-- /wp:separator -->';
    }
}
