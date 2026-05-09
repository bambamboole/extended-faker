<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Formatter;

final readonly class WordPressBlockOptions
{
    public function __construct(
        public bool $includeTitleHeading = true,
        public int $headingOffset = 0,
        public bool $fallbackToHtmlBlock = true,
    ) {}
}
